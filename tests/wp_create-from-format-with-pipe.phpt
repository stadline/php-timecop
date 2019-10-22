--TEST--
DateTimeImmutable::createFromFormat() with a pipe character
--INI--
date.timezone=GMT
timecop.func_override=1
--FILE--
<?php
echo get_class(\DateTime::createFromFormat('Y-m-d|', '2020-01-12')),"\n";
echo get_class(\DateTimeImmutable::createFromFormat('Y-m-d|', '2020-01-12')),"\n";
--EXPECT--
DateTime
DateTimeImmutable
