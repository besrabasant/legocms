<?php

namespace LegoCMS\Listings\Support;

use Illuminate\Support\Collection;
use LegoCMS\Forms\Support\BaseField;
use LegoCMS\Listings\ListingsHeader;

class ListingsHeaders extends Collection
{
    public static function make($args = [])
    {
        return parent::make(array_map(function (BaseField $field) {
            return ListingsHeader::fromField($field);
        }, $args));
    }
}
