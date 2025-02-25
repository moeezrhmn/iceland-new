<?php


use Illuminate\Support\Str;

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 191, $end = '...')
    {
        return Str::limit($value, $limit, $end);
    }
}
