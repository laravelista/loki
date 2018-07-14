<?php

namespace Laravelista\Loki;

use Illuminate\Support\Facades\Route;

trait Loki
{
    protected function mapLocalizedWebRoutes()
    {
        foreach (config('loki.supportedLocales') as $locale) {
            if ($locale == config('loki.defaultLocale')) {
                Route::middleware(['web', 'loki'])
                    ->namespace($this->namespace)
                    ->group($this->getBasePathForWebRoutes($locale));
            }

            Route::prefix($locale)
                ->name("{$locale}.")
                ->middleware(['web', 'loki'])
                ->namespace($this->namespace)
                ->group($this->getBasePathForWebRoutes($locale));
        }
    }

    /**
     * It gets the web routes file path.
     *
     * If the useTranslatedUrls config option is set to true then
     * it returns the path to the web routes file for the given locale.
     */
    protected function getBasePathForWebRoutes($locale)
    {
        if (config('loki.useTranslatedUrls') == true) {
            return base_path("routes/{$locale}.web.php");
        }

        return base_path('routes/loki.web.php');
    }
}