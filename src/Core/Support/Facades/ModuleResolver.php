<?php

namespace LegoCMS\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleResolver extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LegoCMS\Core\ModuleResolver::class;
    }
}
