<?php

namespace LegoCMS\Core\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LegoCMS\Core\ModuleLoader;
use LegoCMS\Core\ModuleResolver;
use LegoCMS\Core\Support\ModuleRepository;
use LegoCMS\Core\RoutesRegistrar;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boots services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        (new RoutesRegistrar())
            ->withAuthRoutes()
            ->register();
    }

    /**
     * Registers Services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(ModuleRepository::class, new ModuleRepository());

        $this->app->bind(ModuleLoader::class, function (Application $app) {
            return new ModuleLoader($app);
        });

        $this->app->bind(ModuleResolver::class, function (Application $app) {
            return new ModuleResolver($app);
        });
    }
}
