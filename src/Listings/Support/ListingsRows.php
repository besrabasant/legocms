<?php

namespace LegoCMS\Listings\Support;

use Illuminate\Support\Collection;
use LegoCMS\Forms\Support\BaseField;
use LegoCMS\Listings\ListingsRow;

class ListingsRows extends Collection
{
    public static function make($args = [])
    {
        return parent::make(array_map(function (BaseField $field) {
            return  new ListingsRow([]);
        }, $args));
    }
}
