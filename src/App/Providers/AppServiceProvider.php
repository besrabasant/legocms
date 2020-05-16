<?php

namespace LegoCMS\App\Providers;

use LegoCMS\App\Modules\Post;
use LegoCMS\Core\Module;
use LegoCMS\Core\Support\Facades\ModuleLoader;
use LegoCMS\Core\Support\Facades\ModuleRepository;
use LegoCMS\Core\Support\LegoAppServiceProvider;
use Illuminate\Support\Facades\Route;
use LegoCMS\App\Http\Controllers\FallbackModuleController;

class AppServiceProvider extends LegoAppServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        ModuleLoader::load([
            Post::class
        ]);
    }

    protected function routes()
    {
        ModuleRepository::each(function (Module $module) {
            $controller = class_exists($module->getController()) ? $module->getController()
                : FallbackModuleController::class;
            Route::resource($module->getModuleName(), $controller);
        });
    }
}
