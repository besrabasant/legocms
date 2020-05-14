<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Module;

abstract class Action extends Component
{
    protected $deferred = false;

    /** @var \LegoCMS\Core\Module */
    protected $module;

    protected $name;

    protected $method = "GET";

    public static function make(Module $module)
    {
        $instance = new static();

        $instance->setModule($module);

        return $instance;
    }

    public function setModule(Module $module)
    {
        $this->module = $module;

        return $this;
    }

    public function setDeferred(bool $value): void
    {
        $this->deferred = $value;
    }

    public function isDeferred(): bool
    {
        return $this->deferred;
    }

    public function fields(): array
    {
        return [];
    }

    public function name()
    {
        return $this->name;
    }

    public function getMethod()
    {
        return $this->method;
    }

    abstract public function handle($request, $model);

    abstract public function url();
}