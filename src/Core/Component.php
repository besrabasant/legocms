<?php

namespace LegoCMS\Core;

use Exception;
use LegoCMS\Core\Behaviors\HasVueAttributes;

abstract class Component
{
    use HasVueAttributes;

    /**
     * @return string
     */
    public function getComponent(): string
    {
        if (!$this->component) {
            throw new Exception('Property $component not defined in class ' . static::class);
        }

        return $this->component;
    }

    public function build()
    {
        return $this;
    }

    public function render(): string
    {
        return "";
    }
}
