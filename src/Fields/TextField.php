<?php

namespace LegoCMS\Fields;

use LegoCMS\Fields\Support\BaseField;

/**
 * TextField class
 */
class TextField extends BaseField
{
    protected $component = "text-field";

    protected function prepareVueAttributes(): array
    {
        return [
            'label' => $this->name,
            'name' => $this->property,
            'value' => $this->getvalue(),
        ];
    }
}
