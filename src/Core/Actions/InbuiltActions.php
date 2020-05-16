<?php

namespace LegoCMS\Core\Actions;

use Illuminate\Support\Collection;
use LegoCMS\Core\Action;

class InbuiltActions extends Collection
{
    protected $namespace = "legocms";

    public static function make($array = [])
    {
        $collection =  parent::make($array);

        return $collection->keyBy(function (Action $item) {
            return $item->name();
        });
    }

    public function findActionByRoute(string $routeName)
    {
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}
