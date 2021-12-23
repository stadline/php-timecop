--TEST--
Check reflection data for overridden functions
--SKIPIF--
<?php
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
	'time' => 'timecop_time',
	'mktime' => 'timecop_mktime',
	'gmmktime' => 'timecop_gmmktime',
	'date' => 'timecop_date',
	'gmdate' => 'timecop_gmdate',
	'idate' => 'timecop_idate',
	'getdate' => 'timecop_getdate',
	'localtime' => 'timecop_localtime',
	'strtotime' => 'timecop_strtotime',
	'strftime' => 'timecop_strftime',
	'gmstrftime' => 'timecop_gmstrftime',
	'date_create' => 'timecop_date_create',
	'date_create_from_format' => 'timecop_date_create_from_format',
	'date_create_immutable' => 'timecop_date_create_immutable',
	'date_create_immutable_from_format' => 'timecop_date_create_immutable_from_format',
];

require __DIR__.'/check-func-refl.inc.php';

--EXPECT--
Checking time vs timecop_time
Checking mktime vs timecop_mktime
Checking gmmktime vs timecop_gmmktime
Checking date vs timecop_date
Checking gmdate vs timecop_gmdate
Checking idate vs timecop_idate
Checking getdate vs timecop_getdate
Checking localtime vs timecop_localtime
Checking strtotime vs timecop_strtotime
Checking strftime vs timecop_strftime
Checking gmstrftime vs timecop_gmstrftime
Checking date_create vs timecop_date_create
Checking date_create_from_format vs timecop_date_create_from_format
Checking date_create_immutable vs timecop_date_create_immutable
Checking date_create_immutable_from_format vs timecop_date_create_immutable_from_format
