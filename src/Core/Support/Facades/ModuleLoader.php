<?php

namespace LegoCMS\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleLoader extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LegoCMS\Core\ModuleLoader::class;
    }
}
