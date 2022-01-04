<?php

function replace_words($input, array $replace)
{
    $patterns = [];
    $replacements = [];

    foreach ($replace as $search => $replacement) {
        $patterns[] = '{\b'.preg_quote($search).'\b}';
        $replacements[] = $replacement;
    }

    return preg_replace($patterns, $replacements, $input);
}

foreach ($functions as $phpFunctionName => $timecopFunctionName) {
    echo sprintf("Checking %s vs %s\n", $phpFunctionName, $timecopFunctionName);

    $phpFunction = new \ReflectionFunction($phpFunctionName);
    $timecopFunction = new \ReflectionFunction($timecopFunctionName);

    $timecopFunctionNormalised = replace_words($timecopFunction, [
        $timecopFunction->getName() => $phpFunction->getName(),
        $timecopFunction->getExtensionName() => $phpFunction->getExtensionName(),
    ]);

    if ((string) $phpFunction !== $timecopFunctionNormalised) {
        echo "php: ", $phpFunction, "\n";
        echo "timecop: ", $timecopFunctionNormalised, "\n";
    }
}
