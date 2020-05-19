<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;

class StoreAction extends Action
{
    protected $name = "store";

    protected $method = "POST";

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
            "%s",
            $this->module->getModuleNamePlural(),
        );
    }
}
