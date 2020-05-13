<?php

namespace LegoCMS\Forms;

use Illuminate\Support\Collection;
use LegoCMS\Core\Component;

class Form extends Component
{
    /** @var string */
    protected $name;

    /** @var \LegoCMS\Core\Module */
    protected $module;

    /** @var string */
    protected $method;

    /** @var string */
    protected $action;

    /** @var string */
    protected $actionUrl;

    /** @var string */
    protected $component = "legocms-form";

    /** @var \Illuminate\Support\Collection */
    protected $fields;

    /**
     * __construct()
     *
     * @param  string $name
     */
    private function __contruct(string $name)
    {
        $this->name = $name;
    }

    /**
     * make()
     *
     * @param  string $name
     * @param  \LegoCMS\Core\Module $module
     *
     * @return static
     */
    public static function make(string $name, $module)
    {
        $instance = new static($name);

        $instance->setModule($module);

        return $instance;
    }

    /**
     * Undocumented function
     *
     * @param  \LegoCMS\Core\Module $module
     *
     * @return static
     */
    protected function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * setAction() : Sets form action.
     *
     * @param  string $action
     *
     * @return static
     */
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * setMethod(): Sets form method.
     *
     * @param  string $method
     *
     * @return static
     */
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * setActionUrl() : Sets form action url.
     *
     * @param  string $url
     * @return static
     */
    public function setActionUrl(string $url)
    {
        $this->actionUrl = $url;

        return $this;
    }

    /**
     * forAction
     *
     * @param  string $action
     *
     * @return static
     */
    public function forAction(string $action)
    {
        $this->setAction($action);

        return $this;
    }

    /**
     * setFormFields
     *
     * @param  \Illuminate\Support\Collection $fields
     *
     * @return static
     */
    public function setFormFields($fields)
    {
        $this->fields = is_array($fields) ? Collection::make($fields) : $fields;

        return $this;
    }

    /**
     * @return void
     */
    public function build()
    {
        $this->buildActionUrl();
    }

    private function buildActionUrl()
    {
        switch ($this->action) {
            case "UPDATE":
                $this->setMethod("PUT");
                $this->setActionUrl($this->module->getRoute("update"));
                break;
            case "CREATE":
            default:
                $this->setMethod("POST");
                $this->setActionUrl($this->module->getRoute("create"));
                break;
        }
    }

    protected function prepareVueAttributes(): array
    {
        return [
            'method' => $this->method,
            'action-url' => $this->actionUrl
        ];
    }
}
