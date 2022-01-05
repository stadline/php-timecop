<?php

function decorateIgnoreDeprecation($expectedMessage, \Closure $callback)
{
    return function () use ($expectedMessage, $callback) {
        $previousHandler = set_error_handler(null, E_DEPRECATED);

        set_error_handler(function ($code, $message, $file, $line) use ($expectedMessage, $previousHandler) {
            if ($message === $expectedMessage) {
                return true;
            }

            // Call the previous handler if it was the non default.
            if ($previousHandler !== null) {
                return $previousHandler($code, $message, $file, $line);
            }

            // Otherwise fallback to the default handler.
            return false;
        }, E_DEPRECATED);

        $result = $callback();

        set_error_handler($previousHandler, E_DEPRECATED);

        return $result;
    };
}

function decorateIfTrue($condition, \Closure $decorator, Closure $callback)
{
    if ($condition) {
        return $decorator($callback);
    }

    return $callback;
}

function execute(\Closure $callback)
{
    return $callback();
}
