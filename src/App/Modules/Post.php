<?php

namespace LegoCMS\App\Modules;

use LegoCMS\Core\Module;
use LegoCMS\Forms\Fields\ID;
use \Illuminate\Http\Request;
use LegoCMS\App\Support\Behaviors\OverridesLegoSetName;

class Post extends Module
{
    use OverridesLegoSetName;

    public function fields(Request $request): array
    {
        return [
            ID::make(),
        ];
    }
}
