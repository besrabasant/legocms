<?php

namespace LegoCMS\App\Support\Behaviors;

trait OverridesLegoSetName
{
    protected function resolveLegoSetName(): string
    {
        return "\\LegoCMS\\App";
    }
}
