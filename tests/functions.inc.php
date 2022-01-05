<?php

function decorateIgnoreDeprecation($expectedMessage, \Closure $callback)
{
    return function () use ($expectedMessage, $callback) {
        set_error_handler(function ($code, $message) use ($expectedMessage) {
            if ($message === $expectedMessage) {
                return true;
            }

            return false;
        }, E_DEPRECATED);

        $result = $callback();

        set_error_handler(null, E_DEPRECATED);

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
