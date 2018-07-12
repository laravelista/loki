<?php

return [
    /**
     * Locale names (codes) can be
     * whatever you want.
     *
     * eg. en-GB, hr-HR, en-US, english,
     *  croatian, german, de, fr, ...
     */
    'supportedLocales' => ['hr', 'en'],

    /**
     * The default application locale.
     * Must be from one of the above.
     */
    'defaultLocale' => 'en',

    /**
     * If you want to hide the default locale
     * in your URL set this to true.
     *
     * eg. If you default locale is set to `en`
     *  then requests to URLs starting with `/en`
     *  will be redirected to `/`.
     */
    'hideDefaultLocale' => true,

    /**
     * If you are using translated URLs
     * for each locale then set this to true.
     *
     * eg. Read the readme on how to set this up.
     *
     *  This enables you to use localized routes.
     *  `/en/about-us` on `en` locale will be
     *  `/hr/o-nama` on `hr` locale.
     */
    'useTranslatedUrls' => false,

    /**
     * Which middleware group is used by default.
     *
     * You can use null to prevent it, a string for
     * one middleware group, or an array of strings
     * for multiple ones.
     */
    'middlewareGroup' => 'web',
];
