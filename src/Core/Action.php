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

    protected $data;

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

    public function setData($data)
    {
        $this->data = $data;
    }

    abstract public function handle($request, $model, $params = null);

    abstract public function url();
}
