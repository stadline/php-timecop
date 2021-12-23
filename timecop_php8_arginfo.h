/*
MIT License

Copyright (c) 2012-2017 Yoshio HANAWA
Copyright (c) 2021 Wider Plan Ltd

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_freeze, 0, 0, 1)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_travel, 0, 0, 1)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_scale, 0, 0, 1)
	ZEND_ARG_INFO(0, scale)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO(arginfo_timecop_return, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO(arginfo_timecop_time, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_mktime, 0, 0, 0)
	ZEND_ARG_INFO(0, hour)
	ZEND_ARG_INFO(0, min)
	ZEND_ARG_INFO(0, sec)
	ZEND_ARG_INFO(0, mon)
	ZEND_ARG_INFO(0, day)
	ZEND_ARG_INFO(0, year)
ZEND_END_ARG_INFO()

#define arginfo_timecop_gmmktime arginfo_timecop_mktime

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_date, 0, 0, 1)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

#define arginfo_timecop_gmdate arginfo_timecop_date

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_idate, 0, 0, 1)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_getdate, 0, 0, 0)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_localtime, 0, 0, 0)
	ZEND_ARG_INFO(0, timestamp)
	ZEND_ARG_INFO(0, associative_array)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_strtotime, 0, 0, 1)
	ZEND_ARG_INFO(0, time)
	ZEND_ARG_INFO(0, now)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_strftime, 0, 0, 1)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

#define arginfo_timecop_gmstrftime arginfo_timecop_strftime

#ifdef HAVE_GETTIMEOFDAY
ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_microtime, 0, 0, 0)
	ZEND_ARG_INFO(0, get_as_float)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_gettimeofday, 0, 0, 0)
	ZEND_ARG_INFO(0, get_as_float)
ZEND_END_ARG_INFO()
#endif

ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_unixtojd, 0, 0, 0)
	ZEND_ARG_INFO(0, timestamp)
ZEND_END_ARG_INFO()

// timecop_date_create()
ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_date_create, 0, 0, 0)
	ZEND_ARG_INFO(0, time)
#if PHP_VERSION_ID >= 70100
	ZEND_ARG_INFO(0, timezone)
#else
	ZEND_ARG_INFO(0, object)
#endif
ZEND_END_ARG_INFO()

// timecop_date_create_from_format()
ZEND_BEGIN_ARG_INFO_EX(arginfo_timecop_date_create_from_format, 0, 0, 2)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, time)
#if PHP_VERSION_ID >= 70200
	ZEND_ARG_OBJ_INFO(0, object, DateTimeZone, 1)
#else
	ZEND_ARG_INFO(0, object)
#endif
ZEND_END_ARG_INFO()

// TimecopDateTime::__construct()
#define arginfo_class_TimecopDateTime___construct arginfo_timecop_date_create

// timecop_date_create_immutable()
#define arginfo_timecop_date_create_immutable arginfo_timecop_date_create

// timecop_date_create_immutable_from_format()
#define arginfo_timecop_date_create_immutable_from_format arginfo_timecop_date_create_from_format

// TimecopDateTimeImmutable::__construct
#define arginfo_class_TimecopDateTimeImmutable___construct arginfo_class_TimecopDateTime___construct
