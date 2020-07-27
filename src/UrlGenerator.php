<?php

namespace Laravelista\Loki;

use Illuminate\Support\Str;
use \Illuminate\Routing\UrlGenerator as LaravelUrlGenerator;

/**
 * This class overrides the default laravel methods
 * for url generation: route and url.
 *
 * It also adds a few helper methods.
 */
class UrlGenerator extends LaravelUrlGenerator
{
    protected $parameter_overrides = [];

    /**
     * This method will set the parameters for given locale, so that
     * when method `getLocalizedRoute` is called it will use
     * these parameters instead of the already present parameters.
     *
     * Useful for translating slugs. Remember to include all parameters.
     */
    public function overrideParameters($locale, $parameters)
    {
        if (is_array($parameters)) {
            $this->parameter_overrides[$locale] = $parameters;
        } else {
            $this->parameter_overrides[$locale] = [$parameters];
        }
    }

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

        // important because of redirect()->route()
        if ($this->isValidUrl($path)) {
            return $path;
        }

        if (!$this->hideDefaultLocale($locale)) {
            $path = $locale . Str::start($path, '/');
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

        if (!$this->hideDefaultLocale($locale)) {
            $name = $locale . '.' . $name;
        }

        return parent::route($name, $parameters, $absolute);
    }

    public function getNonLocalizedRoute($name, $parameters = [], $absolute = true)
    {
        return parent::route($name, $parameters, $absolute);
    }

    public function getNonLocalizedUrl($path, $extra = [], $secure = null)
    {
        return parent::to($path, $extra, $secure);
    }

    protected function areParametersOverridden($locale)
    {
        if (array_key_exists($locale, $this->parameter_overrides)) {
            return true;
        }

        return false;
    }

    public function getLocalizedRoute($locale, $name = null, $parameters = [], $absolute = true)
    {
        if (is_null($name)) {
            $route = request()->route();

            // if the route is not found return dummy Url (404)
            if (is_null($route)) {
                return $this->getLocalizedUrl($locale, request()->path());
            }

            $name = $route->getName();
            $prefix = request()->segment(1);
            // This is a fix for Laravel 6.
            // TODO: Maybe this is not needed anymore...
            $parameters = array_key_exists('data', $route->parameters) ? $route->parameters['data'] : $route->parameters;

            if (!is_null($prefix)) {
                $name = Str::replaceFirst($prefix . '.', '', $name);
            }
        }

        if (!$this->hideDefaultLocale($locale)) {
            $name = $locale . '.' . $name;
        }

        if ($this->areParametersOverridden($locale)) {
            $parameters = $this->parameter_overrides[$locale];
        }

        return parent::route($name, $parameters, $absolute);
    }

    public function getLocalizedUrl($locale, $path = null, $extra = [], $secure = null)
    {
        if (is_null($path)) {
            $path = request()->path();
            $prefix = request()->segment(1);

            if (!is_null($prefix)) {
                $path = Str::replaceFirst($prefix, '', $path);
            }
        }

        if (!$this->hideDefaultLocale($locale)) {
            $path = $locale . Str::start($path, '/');
        }

        return parent::to($path, $extra, $secure);
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
