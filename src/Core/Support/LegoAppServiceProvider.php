<?php

namespace LegoCMS\Core\Support;

use Illuminate\Support\ServiceProvider;

abstract class LegoAppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->routes();
    }

    protected function routes()
    {
    }
}
