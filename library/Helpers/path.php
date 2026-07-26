<?php

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return rtrim(getcwd(), DIRECTORY_SEPARATOR)
            . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

if (! function_exists('view_path')) {
    function view_path(string $path = ''): string
    {
        return base_path('public/views/' . ltrim($path, '/'));
    }
}

if (! function_exists('cache_path')) {
    function cache_path(string $path = ''): string
    {
        return base_path('storage/framework/temp/cache/' . ltrim($path, '/'));
    }
}