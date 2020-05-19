<?php

namespace LegoCMS\Core\Actions;

use LegoCMS\Core\Action;
use LegoCMS\Core\Behaviors\HandlesBulkAction;
use LegoCMS\Core\Contracts\ShouldHandleBulkAction;
use Illuminate\Support\Str;

class BulkDeleteAction extends Action implements ShouldHandleBulkAction
{
    use HandlesBulkAction;

    protected $name = "bulkDelete";

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
            "%s/%s",
            $this->module->getModuleNamePlural(),
            Str::kebab($this->name())
        );
    }
}
