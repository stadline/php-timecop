--TEST--
Check reflection data for overridden functions (On PHP 5.6 timecop_mktime() does not implement the $is_dst parameter)
--SKIPIF--
<?php
$required_version = '7.0';
$required_func = array();
$required_class = array();
$required_method = array();
include(__DIR__."/tests-skipcheck.inc.php");
--INI--
date.timezone=America/Los_Angeles
timecop.func_override=0
--FILE--
<?php

$functions = [
	'mktime' => 'timecop_mktime',
	'gmmktime' => 'timecop_gmmktime',
];

require __DIR__.'/check-func-refl.inc.php';

--EXPECT--
Checking mktime vs timecop_mktime
Checking gmmktime vs timecop_gmmktime
