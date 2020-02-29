<?php

namespace LegoCMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 * @package LegoCMS\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * Handles an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param string $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'legocms_users')
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->to(config('legocms.auth_login_redirect_path', '/'));
        }

        return $next($request);
    }
}
