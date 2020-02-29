<?php

namespace LegoCMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class TurbolinksLocation
 *
 * @package LegoCMS\Http\Middleware
 *
 * Sets the Turbolinks-Location header on every request, so it always works for redirects
 */
class TurbolinksLocation
{
    /**
     * handle
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return \Illuminate\Http\Response;
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        $turbolinksLocation = $request->hasHeader('X-Browsersync-Request') ?
            "http://localhost:3000/{$request->path()}" : $request->url();

        return $response->withHeaders([
            'Turbolinks-Location' => $turbolinksLocation,
        ]);
    }
}
