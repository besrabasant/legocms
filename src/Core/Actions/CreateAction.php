<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;
use LegoCMS\Core\Contracts\CreateAction as CreateActionContract;

class CreateAction extends Action implements CreateActionContract
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
