<?php

namespace LegoCMS\Support;

use BladeSvg\SvgFactory;
use Illuminate\Support\Collection;

class SvgSpritesheet
{
    public static function include(string $spriteSheetPath)
    {
        $config = Collection::make(config('blade-svg', []))->merge([
            'spritesheet_path' => base_path($spriteSheetPath),
            'svg_path' => base_path(config('blade-svg.svg_path', config('blade-svg.icon_path'))),
        ])->all();

        return (new SvgFactory($config))->spritesheet();
    }
}
