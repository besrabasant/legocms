<?php

namespace LegoCMS\Forms;

use LegoCMS\Core\Actions\StoreAction;
use LegoCMS\Core\Component;

class Form extends Component
{
    /** @var string Name of the Form */
    protected $name;

    /** @var \LegoCMS\Core\Module Module to which component refers to. */
    protected $module;

    /** @var string Form method attribute */
    protected $method;

    /** @var \LegoCMS\Core\Action Form action */
    protected $action;

    /** @var string  */
    protected $actionUrl;

    /** @var string */
    protected $component = "legocms-form";

    /** @var \LegoCMS\Forms\FormFields */
    protected $fields;

    /**
     * __construct()
     *
     * @param  string $name
     */
    private function __construct(string $name)
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

        $instance->setAction(StoreAction::make($module));

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
     * @param  \LegoCMS\Core\Action $action
     *
     * @return static
     */
    public function setAction($action)
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
     * @param  \LegoCMS\Core\Action $action
     *
     * @return static
     */
    public function forAction($action)
    {
        $this->setAction($action);

        return $this;
    }

    /**
     * setFormFields
     *
     * @param  \LegoCMS\Forms\FormFields $fields
     *
     * @return static
     */
    public function setFormFields(FormFields $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): void
    {
        $this->buildActionUrl();
    }

    /**
     * buildActionUrl(): Builds Action Url according to action.
     *
     * @return void
     */
    private function buildActionUrl()
    {
        $this->setMethod($this->action->getMethod());
        $this->setActionUrl($this->action->url());
    }

    /** @inheritDoc */
    protected function renderInner(): string
    {
        $innerHtml = "";

        if ($this->fields) {
            $innerHtml = $this->fields->reduce(function ($acc, $field) {
                $acc .= $field->render();
                return $acc;
            }, $innerHtml);
        }

        return $innerHtml;
    }

    /**
     * @inheritDoc
     */
    protected function prepareVueAttributes(): array
    {
        return [
            "name" => $this->name,
            'method' => $this->method,
            'action-url' => $this->actionUrl,
            'token' => \csrf_token(),
        ];
    }
}
