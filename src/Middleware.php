<?php

namespace Laravelista\Loki;

use Closure;
use Illuminate\Http\Request;

class Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $prefix = $route->getPrefix();

        // Hide default locale /en to /
        if (config('loki.hideDefaultLocale') == true and $prefix == config('loki.defaultLocale')) {
            return redirect()->route(str_replace_first($prefix . '.', '', $route->getName()), $route->parameters);
        }

        // Redirect / to default locale /en
        if (config('loki.hideDefaultLocale') == false and is_null($prefix)) {
            return redirect()->route($route->getName(), $route->parameters);
        }

        if (in_array($prefix, config('loki.supportedLocales'))) {
            app()->setLocale($prefix);
        }

        return $next($request);
    }
}
