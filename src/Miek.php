<?php

namespace Laravelista\Loki;

/**
 * Methods for getting URLs localized
 * to specific locales.
 */
class Miek
{
    /**
     * Gets the current URL translated to the desired locale.
     */
    public function __url($locale)
    {
        $url = request()->path();
        $prefix = request()->route()->getPrefix();

        if (!is_null($prefix)) {
            $url = str_replace_first($prefix, '', $url);
        }

        if (config('loki.hideDefaultLocale') == true and $locale == config('loki.defaultLocale')) {
            return url($url, ['dont_localize' => true]);
        }

        return url($locale . str_start($url, '/'), ['dont_localize' => true]);
    }

    /**
     * Gets the current route translated to the desired locale.
     *
     * **Use this when `useTranslatedUrls` config option is set to `true`.**
     */
    public function __route($locale)
    {
        $route = request()->route();
        $name = $route->getName();
        $prefix = $route->getPrefix();
        $parameters = $route->parameters;

        if (!is_null($prefix)) {
            $name = str_replace_first($prefix . '.', '', $name);
        }

        if (config('loki.hideDefaultLocale') == true and $locale == config('loki.defaultLocale')) {
            return route($name, array_merge($parameters, ['dont_localize' => true]));
        }

        return route($locale . '.' . $name, array_merge($parameters, ['dont_localize' => true]));
    }
}