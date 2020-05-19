<?php

namespace LegoCMS\App\Http\Controllers\Behaviors;

use LegoCMS\Core\Module;
use LegoCMS\Core\Support\Facades\ModuleResolver;

trait ResolvesModule
{
    public function resolveModule(string $moduleName): Module
    {
        return ModuleResolver::resolve($moduleName);
    }

    public function resolve(): Module
    {
        return ModuleResolver::resolveFromRequest($this->request);
    }
}
