<?php

use Laraplus\String\StringBuffer;

if (! function_exists('str')) {
    /**
     * Create a string buffer from the given value.
     *
     * @param  mixed  $value
     * @param  string  $encoding
     * @return \Laraplus\String\StringBuffer
     */
    function str($value, $encoding = 'UTF-8')
    {
        return new StringBuffer($value, $encoding);
    }
}