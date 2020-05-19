<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;
use Illuminate\Support\Str;

class ForceDeleteAction extends Action
{
    protected $name = "forceDelete";

    protected $method = "PUT";

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
            "%s/{%s}/%s",
            $this->module->getModuleNamePlural(),
            $this->module->getModuleName(),
            Str::kebab($this->name())
        );
    }
}
