<?php

namespace LegoCMS\Listings;

use LegoCMS\Core\View\AppShell;
use LegoCMS\Core\ViewBuilder;

class ListingsBuilder extends ViewBuilder
{
    protected $listings;

    public function build(): void
    {
        $listings = Listings::make(
            $this->getListingsName(),
            $this->module
        );

        $this->result .= (new AppShell())
            ->setSlot($listings)
            ->render();
    }

    public function getListingsName(): string
    {
        return $this->module->getModuleNamePlural();
    }
}
