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

foreach (['DateTime', 'DateTimeImmutable'] as $className) {
    foreach (['__construct', 'createFromFormat'] as $method) {
        echo sprintf("Checking %1\$s::%2\$s vs Timecop%1\$s::%2\$s\n", $className, $method);

        $phpMethod = new \ReflectionMethod($className, $method);
        $timecopMethod = new \ReflectionMethod('Timecop'.$className, $method);

        $timecopMethodNormalised = replace_words($timecopMethod, [
            $timecopMethod->getName() => $phpMethod->getName(),
            $timecopMethod->getExtensionName() => $phpMethod->getExtensionName(),
            ', overwrites '.$className => '',
            ', prototype '.$className => '',
        ]);

        if ((string) $phpMethod !== $timecopMethodNormalised) {
            echo "php: ", $phpMethod, "\n";
            echo "timecop: ", $timecopMethodNormalised, "\n";
        }
    }
}

--EXPECT--
Checking DateTime::__construct vs TimecopDateTime::__construct
Checking DateTime::createFromFormat vs TimecopDateTime::createFromFormat
Checking DateTimeImmutable::__construct vs TimecopDateTimeImmutable::__construct
Checking DateTimeImmutable::createFromFormat vs TimecopDateTimeImmutable::createFromFormat
