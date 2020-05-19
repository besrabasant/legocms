<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;

class DeleteAction extends Action
{
    protected $name = "delete";

    protected $method = "DELETE";

    public function handle($request, $model, $params = null)
    {
    }

    public function url()
    {
        return $this->module->getRoute($this->name());
    }

    protected function prepareVueAttributes(): array
    {
        return [];
    }

    public function pathSchema(): string
    {
        return sprintf(
            "%s/{%s}",
            $this->module->getModuleNamePlural(),
            $this->module->getModuleName()
        );
    }
}
