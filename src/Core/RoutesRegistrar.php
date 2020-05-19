<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Module;
use Illuminate\Support\Facades\Route;
use LegoCMS\App\Http\Controllers\ModuleController;
use LegoCMS\Core\Actions\CustomActions;
use LegoCMS\Core\Actions\InbuiltActions;
use LegoCMS\Core\Support\Facades\ModuleRepository;
use Illuminate\Support\Str;

class RoutesRegistrar
{
    protected $authRoutes = false;

    public function __construct()
    {
    }

    public function withAuthRoutes()
    {
        $this->authRoutes = true;

        return $this;
    }

    public function register()
    {
        Route::domain($this->appDomain())
            ->group(function () {
                Route::group(['prefix' => \config("legocms.admin_app_path"), "as" => "legocms."], function () {
                    if ($this->authRoutes) {
                        $this->registerAuthRoutes();
                    }

                    $this->registerResourceRoutes()
                        ->registerCustomActionsRoutes()
                        ->registerToolsRoutes();
                });
            });
    }

    protected function appDomain(): string
    {
        return parse_url(\config("legocms.admin_app_url"), PHP_URL_HOST);
    }

    public function registerAuthRoutes()
    {
        Route::group(["as" => "auth."], function () {
        });

        return $this;
    }

    protected function registerResourceRoutes()
    {
        Route::group(["as" => "module."], function () {
            ModuleRepository::each(function (Module $module) {
                $controller = \class_exists($module->getController()) ? $module->getController()
                    : ModuleController::class;

                $defaultActions = InbuiltActions::make($module->defaultActions());

                $resourceItems = ['create', 'store', 'show', 'edit', 'update', 'destroy'];

                $resourceActions = $defaultActions->itemsIn($resourceItems)->names();

                $resourceActions->push('index');

                Route::resource($module->getModuleNamePlural(), $controller)
                    ->names([
                        'destroy' => $module->getModuleNamePlural() . '.delete' // Rename "destroy" to "delete"
                    ])
                    ->only($resourceActions->all());

                // Register Additonal Actions manually.
                $additonalActions = $defaultActions->itemsNotIn($resourceItems);

                $additonalActions->each(function (Action $action) use ($module, $controller) {
                    $method = strtolower($action->getMethod());
                    $controllerMethod = $controller . "@" . $action->name();
                    $name = $module->getModuleNamePlural() . '.' . $action->name();

                    Route::{$method}($action->pathSchema(), $controllerMethod)->name($name);
                });
            });
        });

        return $this;
    }

    protected function registerCustomActionsRoutes()
    {
        Route::group(["as" => "module."], function () {
            ModuleRepository::each(function (Module $module) {

                // $controller = \class_exists($module->getController()) ? $module->getController()
                //     : $this->getDefaultController();
                $actions = new CustomActions($module->actions());
            });
        });

        return $this;
    }

    protected function registerToolsRoutes()
    {
        return $this;
    }

    protected function getDefaultController()
    {
        return $this->defaultController;
    }
}
