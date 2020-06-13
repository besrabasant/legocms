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

        $listingsHeaders = ListingsHeaders::make($this->module->fields($this->app['request']));

        $this->listings->setHeaders($listingsHeaders);

        $this->listings->setListingsData(
            $this->getListingsData($listingsHeaders->getColumns())
        );
    }

    public function getListingsName(): string
    {
        return $this->module->getModuleNamePlural() . "-listings";
    }

    public function getListingsData($columns)
    {
        return $this->module->getModelQueryInstance()->get()->map(function ($item) use ($columns) {
            $rowdata = [];
            foreach ($columns as $column) {
                $rowdata[$column] = $item->{$column};
            }
            return new ListingsRow($rowdata);
        });
    }

    public function renderable()
    {
        return $this->listings;
    }
}
