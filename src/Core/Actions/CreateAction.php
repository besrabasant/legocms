<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;

class CreateAction extends Action
{
    protected $name = "create";

    public function handle($request, $model, $params = null)
    {
    }

    public function url()
    {
        return $this->module->getRoute("create");
    }

    protected function prepareVueAttributes(): array
    {
        return [];
    }

    public function pathSchema(): string
    {
        return sprintf(
            "%s/%s",
            $this->module->getModuleNamePlural(),
            $this->name()
        );
    }
}
