<?php

foreach ($functions as $phpFunctionName => $timecopFunctionName) {
    echo sprintf("Checking %s vs %s\n", $phpFunctionName, $timecopFunctionName);

    $phpFunction = new \ReflectionFunction($phpFunctionName);
    $timecopFunction = new \ReflectionFunction($timecopFunctionName);

    $checkFunction = function ($method) use ($timecopFunction, $phpFunction) {
        if ($phpFunction->$method() !== $timecopFunction->$method()) {
            echo "${method}() failed\n";
            echo "php: "; var_dump($phpFunction->$method());
            echo "timecop: "; var_dump($timecopFunction->$method());
            echo "\n";
        }
    };

    $checkFunction('getNumberOfParameters');
    $checkFunction('getNumberOfRequiredParameters');
    $checkFunction('isDeprecated');
    $checkFunction('isInternal');
    $checkFunction('isUserDefined');
    $checkFunction('isVariadic');
    $checkFunction('returnsReference');

    if (PHP_MAJOR_VERSION >= 7) {
        $checkFunction('hasReturnType');
    }

    if ($phpFunction->getNumberOfParameters() === $timecopFunction->getNumberOfParameters()) {
        foreach ($phpFunction->getParameters() as $idx => $phpParameter) {
            $timecopParameter = $timecopFunction->getParameters()[$idx];

            $checkParameter = function ($method) use ($timecopParameter, $phpParameter) {
                if ($phpParameter->$method() !== $timecopParameter->$method()) {
                    echo "Parameter {$phpParameter->getName()} ${method}() failed\n";
                    echo "php: "; var_dump($phpParameter->$method());
                    echo "timecop: "; var_dump($timecopParameter->$method());
                    echo "\n";
                }
            };

            $checkParameter('getName');
            $checkParameter('allowsNull');
            $checkParameter('isDefaultValueAvailable');
            $checkParameter('isOptional');

            if (PHP_MAJOR_VERSION >= 7) {
                $checkParameter('hasType');

                $phpParameterType = $phpParameter->getType();
                $timecopParameterType = $timecopParameter->getType();
                $getClass = function (\ReflectionType $type = null) {
                    return $type === null ? '' : get_class($type);
                };

                $allowsNull = function (\ReflectionType $type = null) {
                    return $type === null ? null : $type->allowsNull();
                };

                if ($getClass($phpParameterType) !== $getClass($timecopParameterType)) {
                    echo "Parameter {$phpParameter->getName()} Type()::class failed\n";
                    echo "php: "; var_dump($getClass($phpParameterType));
                    echo "timecop: "; var_dump($getClass($timecopParameterType));
                    echo "\n";
                }

                if ($allowsNull($phpParameterType) !== $allowsNull($timecopParameterType)) {
                    echo "Parameter {$phpParameter->getName()} getType()->allowsNull() failed\n";
                    echo "php: "; var_dump($allowsNull($phpParameterType));
                    echo "timecop: "; var_dump($allowsNull($timecopParameterType));
                    echo "\n";
                }
            }
        }
    } else {
        echo "Mismatched number of parameters...\n";
        echo "{$phpFunction->getName()}() parameters:\n";

        foreach ($phpFunction->getParameters() as $phpParameter) {
            echo "\t- {$phpParameter->getName()}\n";
        }

        echo "{$timecopFunction->getName()}() parameters:\n";

        foreach ($timecopFunction->getParameters() as $timecopParameter) {
            echo "\t- {$timecopParameter->getName()}\n";
        }

        echo "\n";
    }
}
