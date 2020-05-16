<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Contracts\Skleton;
use LegoCMS\Core\Support\BaseSkleton;

class DefaultSkleton extends BaseSkleton implements Skleton
{
    public function modelsFolder(): string
    {
        return "Models";
    }

    public function modulesFolder(): string
    {
        return "Modules";
    }

    public function contractsFolder(): string
    {
        return "Support/Contracts";
    }

    public function providersFolder(): string
    {
        return "Providers";
    }

    public function controllersFolder(): string
    {
        return "Http/Controllers";
    }

    public function requestsFolder(): string
    {
        return "Http/Requests";
    }

    public function routesFolder(): string
    {
        return "routes";
    }

    public function viewsFolder(): string
    {
        return "resoures/views";
    }

    public function configFolder(): string
    {
        return "config";
    }
}
