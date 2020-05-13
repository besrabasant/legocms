<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Module;

abstract class ViewBuilder
{
    protected $module;

    private function __contruct()
    {
    }

    public static function make(Module $module)
    {
        $instance =  new static;

        $instance->setModule($module);

        return $instance;
    }

    public function setModule(Module $module)
    {
        $this->module = $module;
        return $this;
    }

    abstract public function build(): void;
}
