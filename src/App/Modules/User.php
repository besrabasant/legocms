<?php

namespace LegoCMS\App\Modules;

use LegoCMS\Core\Module;
use LegoCMS\Fields\ID;
use \Illuminate\Http\Request;

class User extends Module
{
    public function fields(Request $request): array
    {
        return [
            ID::make(),
        ];
    }
}
