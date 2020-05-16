<?php

namespace DemoSet1\Providers;

use DemoSet1\Modules\Article;
use LegoCMS\Core\Support\Facades\ModuleLoader;
use LegoCMS\Core\Support\LegoAppServiceProvider;

class ModuleServiceProvider extends LegoAppServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        // ModuleLoader::loadFrom(__DIR__ . "/../Modules", "DemoSet1\\Modules");
        ModuleLoader::load([
            Article::class
        ]);
    }
}
