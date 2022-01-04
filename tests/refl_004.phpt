--TEST--
Check reflection data for overridden functions
--SKIPIF--
<?php
$required_func = array("unixtojd");
$required_class = array();
$required_method = array();
include(__DIR__."/tests-skipcheck.inc.php");
--INI--
date.timezone=America/Los_Angeles
timecop.func_override=0
--FILE--
<?php

$functions = [
	'unixtojd' => 'timecop_unixtojd',
];

require __DIR__.'/check-func-refl.inc.php';

--EXPECT--
Checking unixtojd vs timecop_unixtojd
