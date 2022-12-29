--TEST--
Test with faketime
--SKIPIF--
<?php
include(__DIR__."/tests-skipcheck.inc.php");
if (DIRECTORY_SEPARATOR === '\\') die('skip does not run on windows');
if (exec('which faketime') === '') die('skip faketime is not installed');
--INI--
date.timezone=GMT
timecop.func_override=0
--XFAIL--
time() is not using the overloaded gettimeofday() function
--FILE--
<?php
echo "passthru():\n";
passthru(sprintf(
    'faketime "1970-01-01 12:00:00" %s %s -r "var_dump(time(), timecop_time());"',
    PHP_BINARY,
    $_SERVER['TEST_PHP_EXTRA_ARGS'],
));
--EXPECT--
passthru():
int(39600)
int(39600)
