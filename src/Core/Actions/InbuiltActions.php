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

    public function itemsIn($in_array)
    {
        return $this->filter(function (Action $item) use ($in_array) {
            return in_array($item->name(), $in_array);
        });
    }

    public function itemsNotIn($in_array)
    {
        return $this->reject(function (Action $item) use ($in_array) {
            return in_array($item->name(), $in_array);
        });
    }


    public function names()
    {
        return $this->keys();
    }

    public function getNamespace()
    {
        return $this->namespace;
    }
}
