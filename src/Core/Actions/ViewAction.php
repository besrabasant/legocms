<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;

class ViewAction extends Action
{
    protected $name = "show";

    protected $method = "GET";

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
}
