<?php

namespace LegoCMS\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use LegoCMS\Http\Middleware\NoDebugbar;
use LegoCMS\Http\Middleware\RedirectIfAuthenticated;
use LegoCMS\Http\Middleware\TurbolinksLocation;
use LegoCMS\Services\LegoSet;
use LegoCMS\Support\Facades\LegoCMS;
use LegoCMS\Support\Macros\RouteModuleMacro;

/**
 * Class RouteServiceProvider
 *
 * @category ServiceProviders
 * @package  LegoCMS\Providers
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Providers/RouteServiceProvider.php
 */
class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'LegoCMS\Http\Controllers';

    public const HOME = 'dashboard';

    /**
     * Boots any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRouteMiddlewares($this->app['router']);

        $this->registerRouteMacros();

        parent::boot();
    }

    /**
     * Maps application routes.
     *
     * @param  Router  $router
     *
     * @return  void
     */
    public function map(Router $router)
    {
        $groupOptions = [
            'as' => 'legocms.',
            'domain' => \config("legocms.admin_app_url"),
            'prefix' => trim(\config("legocms.admin_app_path"), '/'),
            'middleware' => \config("legocms.admin_middleware_group", ["web"]),
        ];

        $this->mapAuthRoutes($router, $groupOptions);
        // $this->mapHostRoutes($router, $groupOptions); // TODO: Add Implementation to load front end routes from LegoSets
        $this->mapAdminRoutes($router, $groupOptions);
    }

    /**
     * Maps Authentication Routes.
     *
     * @param  Router $router
     * @param  $groupOptions
     *
     * @return void
     */
    protected function mapAuthRoutes(Router $router, $groupOptions = [])
    {
        $authenticationRoutesMiddlewares = [
            'noDebugbar',
            'turbolinks_location',
        ];

        $router->group(
            $groupOptions,
            function (Router $router) use ($authenticationRoutesMiddlewares) {
                $router->middleware($authenticationRoutesMiddlewares)
                    ->name('admin.')
                    ->namespace($this->namespace . '\Admin\Auth')
                    ->group(__DIR__ . '/../../routes/auth.php');
            }
        );
    }

    /**
     * Maps Admin Routes.
     *
     * @param  Router $router
     * @param  $groupOptions
     *
     * @return void
     */
    protected function mapAdminRoutes(Router $router, $groupOptions = [])
    {
        $adminRoutesMiddlewares = [
            'legocms_auth:legocms_users',
            'turbolinks_location',
            // 'impersonate',
            // 'validateBackHistory',
        ];

        $router->group(
            $groupOptions,
            function (Router $router) use ($adminRoutesMiddlewares) {
                $router->middleware($adminRoutesMiddlewares)
                    ->group(function () use ($router) {
                        $this->mapInternalAdminRoutes($router);
                        $this->mapLegoSetsRoutes($router);
                    });
            }
        );
    }

    /**
     * Maps internal admin routes.
     *
     * @param  Router  $router
     * @param  array  $groupOptions
     *
     * @return  void
     */
    protected function mapInternalAdminRoutes(Router $router, $groupOptions = [])
    {
        $router->namespace($this->namespace . '\Admin')
            ->group(__DIR__ . '/../../routes/admin.php');
    }

    /**
     * Maps Lego Sets routes.
     *
     * @param  Router  $router
     * @param  array  $groupOptions
     *
     * @return  void
     */
    protected function mapLegoSetsRoutes(Router $router, $groupOptions = [])
    {
        $legoSets = LegoCMS::all();

        $legoSets->each(function (LegoSet $legoSet) use ($router) {
            $routes_dir = $legoSet->hasRoutesDir() ? $legoSet->getRoutesDir() : $legoSet->getPackageRoot() . "routes/";

            $router->namespace("{$legoSet->getNamespace()}Http\Controllers\Admin")
                ->group("{$routes_dir}admin.php");
        });
    }

    /**
     * Registers middlewares.
     *
     * @param  \Illuminate\Routing\Router  $router
     *
     * @return  void
     */
    protected function registerRouteMiddlewares(Router $router)
    {
        $router->aliasMiddleware('noDebugbar', NoDebugbar::class);
        $router->aliasMiddleware('legocms_auth', Authenticate::class);
        $router->aliasMiddleware('legocms_guest', RedirectIfAuthenticated::class);
        $router->aliasMiddleware('turbolinks_location', TurbolinksLocation::class);
    }

    /**
     * Registers Route Macros.
     *
     * @return  void
     */
    protected function registerRouteMacros()
    {
        Route::macro('module', \app(RouteModuleMacro::class)());
        Route::macro('bricks', \app(RouteModuleMacro::class)());
    }
}
