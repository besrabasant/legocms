<?php

namespace LegoCMS\Support\Behaviors;

trait ResolvesLegoSetName
{
    protected function resolveLegoSetName(): string
    {
        return \ltrim(\explode("\\", static::class)[0], "\\");
    }
}
