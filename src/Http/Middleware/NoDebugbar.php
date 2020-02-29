<?php

namespace LegoCMS\Http\Middleware;

use Closure;
use Barryvdh\Debugbar\Facade as Debugbar;

/**
 * Class NoDebugbar
 * @package LegoCMS\Http\Middleware
 */
class NoDebugbar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Debugbar::disable();

        return $next($request);
    }
}
