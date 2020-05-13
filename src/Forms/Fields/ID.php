<?php

namespace LegoCMS\Forms\Fields;

use LegoCMS\Forms\Support\BaseField;

class ID extends BaseField
{
    protected $component = "id-field";

    public static function make(string $name = "ID", callable $property = null)
    {
        return parent::make($name, $property);
    }

    protected function prepareVueAttributes(): array
    {
        return [
            'value' => $this->value,
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return self
     */
    public static function fromModel($model): self
    {
        return tap(static::make("ID"))
            ->setValue($model->{$model->getKeyName()});
    }
}
