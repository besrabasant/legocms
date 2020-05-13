<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;

class CreateAction extends Action
{
    public function handle($request, $model)
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
}
