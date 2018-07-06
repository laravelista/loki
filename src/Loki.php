<?php

namespace Laravelista\Loki;

class Loki
{
    protected $locale;

    protected $hideDefaultLocale;

    public function __construct()
    {
        $this->locale = app()->getLocale();

        $this->hideDefaultLocale = config('loki.hideDefaultLocale');
    }

    /**
     * When you use `__route('/')` helper function in your application
     * this method gets called. It returns the translated URL based
     * on a few factors.
     */
    public function __route($name, $locale = null)
    {
        if ($this->hideDefaultLocale()) {
            return route($name);
        }

        return route($this->locale . '.' . $name);
    }

    /**
     * When you use `__url('/')` helper function in your application
     * this method gets called. It returns the translated URL based
     * on a few factors.
     */
    public function __url($url, $locale = null)
    {
        // the user wants the given url to be returned for the specified locale
        if (!is_null($locale)) {
            $prefix = request()->route()->getPrefix();

            // remove current locale from the start of the url
            if (!is_null($prefix)) {
                $url = str_replace_first($prefix, '', $url);
            }

            if ($this->hideDefaultLocale == true and $locale == config('loki.defaultLocale')) {
                return url($url);
            }

            return url($locale . str_start($url, '/'));
        }

        if ($this->hideDefaultLocale()) {
            return url($url);
        }

        return url($this->locale . str_start($url, '/'));
    }

    /**
     * It returns true if the current locale is the default locale and
     * the option to hide the default locale is set to true.
     */
    protected function hideDefaultLocale()
    {
        if ($this->hideDefaultLocale == true and
            $this->locale == config('loki.defaultLocale')) {
            return true;
        }

        return false;
    }

    /**
     * Get the current URL translated to the desired locale.
     */
    public function __currentUrl($locale)
    {
        $url = request()->path();
        $prefix = request()->route()->getPrefix();

        if (!is_null($prefix)) {
            $url = str_replace_first($prefix, '', $url);
        }

        if ($this->hideDefaultLocale == true and $locale == config('loki.defaultLocale')) {
            return url($url);
        }

        return url($locale . str_start($url, '/'));
    }

    /**
     * Gets the current route translated to the desired locale.
     *
     * **Use this when `useTranslatedUrls` config option is set to `true`.**
     */
    public function __currentRoute($locale)
    {
        $name = request()->route()->getName();
        $prefix = request()->route()->getPrefix();

        if (!is_null($prefix)) {
            $name = str_replace_first($prefix . '.', '', $name);
        }

        if ($this->hideDefaultLocale == true and $locale == config('loki.defaultLocale')) {
            return route($name);
        }

        return route($locale . '.' . $name);
    }
}