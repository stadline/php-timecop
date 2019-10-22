--TEST--
DateTimeImmutable::createFromFormat() with a pipe character
--INI--
date.timezone=GMT
timecop.func_override=1
--FILE--
<?php
declare(strict_types=1);

echo get_class(\DateTimeImmutable::createFromFormat('Y-m-d|', '2020-01-12'));
--EXPECT--
DateTimeImmutable
