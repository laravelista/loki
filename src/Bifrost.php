<?php

namespace Laravelista\Loki;

use Illuminate\Support\Facades\Route;

/**
 * Bifrost (pronounced roughly “BEEF-roast;” Old Norse Bifröst)
 * is the rainbow bridge that connects your application, the perfection of modern coding,
 * with Loki, the best laravel localization package in the world.
 */
trait Bifrost
{
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        foreach (config('loki.supportedLocales') as $locale) {
            if ($locale == config('loki.defaultLocale')) {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group($this->getBasePathForWebRoutes($locale));
            }

            Route::prefix($locale)
                ->name("{$locale}.")
                ->middleware('web')
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

        return base_path('routes/web.php');
    }
}