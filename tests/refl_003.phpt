--TEST--
Check reflection data for overridden functions
--SKIPIF--
<?php
$required_func = array("microtime", "gettimeofday");
$required_class = array();
$required_method = array();
include(__DIR__."/tests-skipcheck.inc.php");
--INI--
date.timezone=America/Los_Angeles
timecop.func_override=0
--FILE--
<?php

$functions = [
	'microtime' => 'timecop_microtime',
	'gettimeofday' => 'timecop_gettimeofday',
];

require __DIR__.'/check-func-refl.inc.php';

--EXPECT--
Checking microtime vs timecop_microtime
Checking gettimeofday vs timecop_gettimeofday
