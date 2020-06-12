<?php

namespace LegoCMS\Listings;

use LegoCMS\Core\Component;
use LegoCMS\Forms\Support\BaseField;

class ListingsHeader extends Component
{
    protected $component = "legocms-listings-header";

    protected $columnKey;

    protected $columnName;

    /**
     * primary : If the header is a primary header.
     *
     * @var bool
     */
    protected $primary = false;

    public function __construct($columnKey, $columnName)
    {
        $this->columnKey = $columnKey;
        $this->columnName = $columnName;
    }

    public static function fromField(BaseField $field)
    {
        $instance = new static($field->getProperty(), $field->getName());
        $instance->setPrimary($field->isPrimaryField());
        return $instance;
    }

    public function setPrimary(bool $value)
    {
        $this->primary = $value;
    }

    protected function prepareVueAttributes(): array
    {
        $attributes = [
            'column' => $this->columnKey
        ];

        if ($this->primary) {
            $attributes['primary'] = true;
        }

        return $attributes;
    }

    protected function renderInner(): string
    {
        return $this->columnName;
    }
}
