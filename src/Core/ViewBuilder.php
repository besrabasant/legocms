<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Module;

abstract class ViewBuilder
{
    /** @var \LegoCMS\Core\Module */
    protected $module;

    /** @var \Illuminate\Foundation\Application */
    protected $app;

    private function __construct()
    {
        $this->app = \app();
    }

    /**
     * make
     *
     * @param  mixed $module
     * @return void
     */
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

    abstract public function renderable();
}
