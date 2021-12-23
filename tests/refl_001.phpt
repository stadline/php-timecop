--TEST--
Check reflection data for overridden methods
--SKIPIF--
<?php
$required_func = array();
$required_class = array("TimecopDateTime", "TimecopDateTimeImmutable", "ReflectionMethod");
$required_method = array();
include(__DIR__."/tests-skipcheck.inc.php");
--INI--
date.timezone=America/Los_Angeles
timecop.func_override=0
--FILE--
<?php

foreach (['DateTime', 'DateTimeImmutable'] as $className) {
    foreach (['__construct', 'createFromFormat'] as $method) {
        echo sprintf("Checking %1\$s::%2\$s vs Timecop%1\$s::%2\$s\n", $className, $method);

        $phpMethod = new \ReflectionMethod($className, $method);
        $timecopMethod = new \ReflectionMethod('Timecop'.$className, $method);

        $checkMethod = function ($method) use ($timecopMethod, $phpMethod) {
            if ($phpMethod->$method() !== $timecopMethod->$method()) {
                echo "${method}() failed\n";
                echo "php: "; var_dump($phpMethod->$method());
                echo "timecop: "; var_dump($timecopMethod->$method());
                echo "\n";
            }
        };

        $checkMethod('isAbstract');
        $checkMethod('isConstructor');
        $checkMethod('isDestructor');
        $checkMethod('isFinal');
        $checkMethod('isPrivate');
        $checkMethod('isProtected');
        $checkMethod('isPublic');
        $checkMethod('isStatic');
        $checkMethod('getNumberOfParameters');
        $checkMethod('getNumberOfRequiredParameters');
        $checkMethod('isDeprecated');
        $checkMethod('isInternal');
        $checkMethod('isUserDefined');
        $checkMethod('isVariadic');
        $checkMethod('returnsReference');

        if (PHP_MAJOR_VERSION >= 7) {
            $checkMethod('hasReturnType');
        }

        if ($phpMethod->getNumberOfParameters() === $timecopMethod->getNumberOfParameters()) {
            foreach ($phpMethod->getParameters() as $idx => $phpParameter) {
                $timecopParameter = $timecopMethod->getParameters()[$idx];

                $checkParameter = function ($method) use ($timecopParameter, $phpParameter) {
                    if ($phpParameter->$method() !== $timecopParameter->$method()) {
                        echo "Parameter {$phpParameter->getName()}${method}() failed\n";
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
            echo "{$phpMethod->getName()}() parameters:\n";

            foreach ($phpMethod->getParameters() as $phpParameter) {
                echo "\t- {$phpParameter->getName()}\n";
            }

            echo "{$timecopMethod->getName()}() parameters:\n";

            foreach ($timecopMethod->getParameters() as $timecopParameter) {
                echo "\t- {$timecopParameter->getName()}\n";
            }

            echo "\n";
        }
    }
}

--EXPECT--
Checking DateTime::__construct vs TimecopDateTime::__construct
Checking DateTime::createFromFormat vs TimecopDateTime::createFromFormat
Checking DateTimeImmutable::__construct vs TimecopDateTimeImmutable::__construct
Checking DateTimeImmutable::createFromFormat vs TimecopDateTimeImmutable::createFromFormat
