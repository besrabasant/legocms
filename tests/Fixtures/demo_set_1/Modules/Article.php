<?php

namespace DemoSet1\Modules;

use LegoCMS\Core\Module;
use LegoCMS\Fields\ID;
use \Illuminate\Http\Request;

class Article extends Module
{
    public function fields(Request $request): array
    {
        return [
            ID::make(),
        ];
    }
}
