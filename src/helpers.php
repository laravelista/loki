<?php

use Laravelista\Loki\Loki;

if (!function_exists('__route')) {
    /**
     * @param $name
     *
     * @return string
     */
    function __route($name)
    {
        return app(Loki::class)->__route($name);
    }
}

if (!function_exists('__url')) {
    /**
     * @param $url
     *
     * @return string
     */
    function __url($url)
    {
        return app(Loki::class)->__url($url);
    }
}

if (!function_exists('__currentUrl')) {
    /**
     * @param $locale
     *
     * @return string
     */
    function __currentUrl($locale)
    {
        return app(Loki::class)->__currentUrl($locale);
    }
}

if (!function_exists('__currentRoute')) {
    /**
     * @param $locale
     *
     * @return string
     */
    function __currentRoute($locale)
    {
        return app(Loki::class)->__currentRoute($locale);
    }
}