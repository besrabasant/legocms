<?php

namespace LegoCMS\Core;

use LegoCMS\Core\Contracts\ShouldHandleBulkAction;
use LegoCMS\Core\Module;

abstract class Action extends Component
{
    /** @var bool */
    protected $deferred = false;

    /** @var \LegoCMS\Core\Module */
    protected $module;

    /** @var string */
    protected $name;

    /** @var string */
    protected $method = "GET";

    /** @var mixed */
    protected $data;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * make
     *
     * @param  \LegoCMS\Core\Module $module
     * @return static
     */
    public static function make(Module $module)
    {
        $instance = new static();

        $instance->setModule($module);

        return $instance;
    }

    /**
     * setModule
     *
     * @param  \LegoCMS\Core\Module $module
     * @return static
     */
    public function setModule(Module $module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * setDeferred
     *
     * @param  bool $value
     * @return static
     */
    public function setDeferred(bool $value)
    {
        $this->deferred = $value;

        return $this;
    }

    /**
     * isDeferred
     *
     * @return bool
     */
    public function isDeferred(): bool
    {
        return $this->deferred;
    }

    /**
     * fields
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * setData
     *
     * @param  mixed $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * getRouteName
     *
     * @return string
     */
    public function getRouteName(): string
    {
        return sprintf("%s.%s", $this->module->getModuleNamePlural(), $this->name());
    }

    /**
     * shouldHandleBulk
     *
     * @return bool
     */
    public function shouldHandleBulk(): bool
    {
        return \class_implements_interface(static::class, ShouldHandleBulkAction::class);
    }

    /**
     * pathSchema
     *
     * @return string
     */
    abstract public function pathSchema(): string;

    abstract public function handle($request, $model, $params = null);

    abstract public function url();
}
