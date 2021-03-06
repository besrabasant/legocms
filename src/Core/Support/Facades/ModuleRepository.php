<?php

namespace LegoCMS\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LegoCMS\Core\Support\ModuleRepository::class;
    }
}
