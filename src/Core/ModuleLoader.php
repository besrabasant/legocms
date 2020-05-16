<?php

namespace LegoCMS\Core;

use Illuminate\Foundation\Application;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Str;
use LegoCMS\Core\Support\Facades\ModuleRepository;

class ModuleLoader
{
    /** @var \Illuminate\Foundation\Application */
    protected $application;

    /**
     * __construct
     *
     * @param  \Illuminate\Foundation\Application $application
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application  = $application;
    }

    public function loadFrom($directory, $namespace = null)
    {
        $namespace = $namespace ? $namespace . "\\" : $this->application->getNamespace();

        $modules = [];

        foreach ((new Finder)->in($directory)->files() as $module) {
            $module = $namespace . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($module->getPathname(), $directory . DIRECTORY_SEPARATOR)
            );

            if (is_subclass_of($module, Module::class) && !(new ReflectionClass($module))->isAbstract()) {
                $modules[] = $module;
            }
        }

        $this->load(
            collect($modules)->sort()->all()
        );
    }

    public function load(array $modules)
    {
        foreach ($modules as $module) {
            /** @var \LegoCMS\Core\Module */
            $moduleInstance = $module::make();

            /** @var ModuleRepository */
            ModuleRepository::put($moduleInstance->getModuleName(), $moduleInstance);

            $this->application->instance($module, $moduleInstance);
            $this->application->alias($module, "legocms::module." . $moduleInstance->getModuleName());
        }
    }
}
