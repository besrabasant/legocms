<?php

namespace LegoCMS\Core\Contracts;

interface Skleton
{
    public function modelsFolder(): string;
    public function modulesFolder(): string;
    public function contractsFolder(): string;
    public function providersFolder(): string;
    public function controllersFolder(): string;
    public function requestsFolder(): string;
    public function routesFolder(): string;
    public function viewsFolder(): string;
    public function configFolder(): string;
}
