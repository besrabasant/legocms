<?php

namespace LegoCMS\App\Providers;

use LegoCMS\App\Modules\Post;
use LegoCMS\Core\Support\Facades\ModuleLoader;
use LegoCMS\Core\Support\LegoAppServiceProvider;

class AppServiceProvider extends LegoAppServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        ModuleLoader::load([
            Post::class
        ]);
    }
}
