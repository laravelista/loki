<?php

use Laravelista\Loki\Miek;

if (!function_exists('__route')) {
    /**
     * @param $locale
     *
     * @return string
     */
    function __route($locale)
    {
        return app(Miek::class)->__route($locale);
    }
}

if (!function_exists('__url')) {
    /**
     * @param $locale
     *
     * @return string
     */
    function __url($locale)
    {
        return app(Miek::class)->__url($locale);
    }
}