<?php

namespace Laravelista\Loki;

use \Illuminate\Routing\UrlGenerator;

/**
 * This class overrides the default laravel methods
 * for url generation: route and url.
 */
class Loki extends UrlGenerator
{
    /**
     * Generate an absolute URL to the given localized path.
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        $locale = app()->getLocale();

        if (!$this->hideDefaultLocale($locale) and !in_array('dont_localize', $extra)) {
            $path = $locale . str_start($path, '/');
        }

        if (in_array('dont_localize', $extra)) {
            unset($extra['dont_localize']);
        }

        return parent::to($path, $extra, $secure);
    }

    /**
     * Get the URL to a named localized route.
     *
     * @param  string  $name
     * @param  mixed   $parameters
     * @param  bool  $absolute
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        $locale = app()->getLocale();

        if (!$this->hideDefaultLocale($locale) and !in_array('dont_localize', $parameters)) {
            $name = $locale . '.' . $name;
        }

        if (in_array('dont_localize', $parameters)) {
            unset($parameters['dont_localize']);
        }

        return parent::route($name, $parameters, $absolute);
    }

    /**
     * It returns true if the current locale is the default locale and
     * the option to hide the default locale is set to true.
     */
    protected function hideDefaultLocale($locale)
    {
        if (config('loki.hideDefaultLocale') == true and
            $locale == config('loki.defaultLocale')) {
            return true;
        }

        return false;
    }
}