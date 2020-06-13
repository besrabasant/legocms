<?php

namespace LegoCMS\App\Modules;

use LegoCMS\Core\Module;
use \Illuminate\Http\Request;
use LegoCMS\App\Support\Behaviors\OverridesLegoSetName;
use LegoCMS\Fields\ID;
use LegoCMS\Fields\TextField;

class Post extends Module
{
    use OverridesLegoSetName;

    public function fields(Request $request): array
    {
        return [
            ID::make(),
            TextField::make("Title"),
            TextField::make("Description"),
            TextField::make("Content"),
        ];
    }
}
