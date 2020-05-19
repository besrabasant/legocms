<?php

namespace LegoCMS\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

class ListingsView extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LegoCMS\Core\View\ListingsView::class;
    }
}
