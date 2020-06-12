<?php

namespace LegoCMS\Listings;

use LegoCMS\Core\ViewBuilder;
use LegoCMS\Listings\Support\ListingsHeaders;

class ListingsBuilder extends ViewBuilder
{
    /** @var \LegoCMS\Listings\Listings */
    protected $listings;

    public function build(): void
    {
        $this->listings = Listings::make(
            $this->getListingsName(),
            $this->module
        );

        dd($this->module->getModelInstance());

        $this->listings->setHeaders(
            ListingsHeaders::make($this->module->fields($this->app['request']))
        );
    }

    public function getListingsName(): string
    {
        return $this->module->getModuleNamePlural() . "-listings";
    }

    public function renderable()
    {
        return $this->listings;
    }
}
