<?php

namespace LegoCMS\Listings;

use LegoCMS\Core\Component;

class ListingsRow extends Component
{
    protected $component = "legocms-listings-row";

    protected $rowKeys = [];

    protected $rowData;

    public function __construct($rowData)
    {
        $this->rowData = $rowData;
    }

    public function setRowKeys(array $rowKeys)
    {
        $this->rowKeys = $rowKeys;
    }

    protected function setRowData($rowData)
    {
        $this->rowData = $rowData;
    }

    protected function prepareVueAttributes(): array
    {
        return $this->rowData;
    }
}
