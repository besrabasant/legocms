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

    public function contractsFolder(): string
    {
        return "Support/Contracts";
    }

    public function providersFolder(): string
    {
        return "Admin/Providers";
    }

    public function controllersFolder(): string
    {
        return "Admin/Http/Controllers";
    }

    public function requestsFolder(): string
    {
        return "Admin/Http/Requests";
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
