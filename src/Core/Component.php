<?php

namespace LegoCMS\Core;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\HtmlString;
use LegoCMS\Core\Behaviors\HasVueAttributes;

abstract class Component implements Renderable
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

    /**
     * build
     *
     * @return void
     */
    public function build(): void
    {
    }

    /**
     * renderInner(): Renders component inner content
     *
     * @return string
     */
    protected function renderInner(): string
    {
        return "";
    }

    public function render()
    {
        $this->build();

        $renderString = "<" . $this->getComponent();

        if ($attributes = $this->toVueAttributes()) {
            $renderString .= " " . $attributes;
        }

        $renderString .= ">";

        if ($innerHtml = $this->renderInner()) {
            $renderString .= PHP_EOL . "\t" . $innerHtml . PHP_EOL;
        }

        $renderString .= "</" . $this->getComponent() . ">";

        return new HtmlString($renderString);
    }
}
