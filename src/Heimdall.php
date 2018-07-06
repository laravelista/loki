<?php

namespace Laravelista\Loki;

use Closure;

class Heimdall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = $request->route()->getPrefix();

        // Hide default locale /en to /
        if (config('loki.hideDefaultLocale') == true and $prefix == config('loki.defaultLocale')) {
            return redirect()->route(str_replace_first($prefix . '.', '', $request->route()->getName()));
        }

        // Redirect / to default locale /en
        if (config('loki.hideDefaultLocale') == false and is_null($prefix)) {
            return redirect()->route(config('loki.defaultLocale') . '.' . $request->route()->getName());
        }

        if (in_array($prefix, config('loki.supportedLocales'))) {
            app()->setLocale($prefix);
        }

        return $next($request);
    }
}
