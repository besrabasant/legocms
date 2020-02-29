<?php

namespace DemoSet1\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LegoCMS\Support\Facades\LegoCMS;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        LegoCMS::addLegoSet("demoset1", [
            'namespace' => "DemoSet1\\",
            'package_root' => __DIR__ . "/../",
            'routes_dir' => __DIR__ . "/../routes/"
        ]);
    }
}
