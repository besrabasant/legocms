<?php

namespace LegoCMS\Core;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\HtmlString;
use LegoCMS\Core\Behaviors\HasVueAttributes;

abstract class Component implements Renderable
{
    use HasVueAttributes;

    protected $slots = [];

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
     *
     * @param [type] $component
     * @param string $slotName
     * @return void
     */
    public function setSlot($component, $slotName = "default")
    {
        if (!\array_key_exists($slotName, $this->slots)) {
            $this->slots[$slotName] = [];
        }

        $this->slots[$slotName][] = $component;

        return $this;
    }

    /**
     * renderInner(): Renders component inner content
     *
     * @return string
     */
    protected function renderInner(): string
    {
        $innerHtml = "";

        foreach ($this->slots as $slotName => $slotComponents) {

            $slotContent = "";

            foreach ($slotComponents as $component) {
                $slotContent .= $component->render();
            }

            if ($slotName != 'default') {
                $innerHtml .= "<template #" . $slotName . ">" .
                    $slotContent .
                    "</template>";
            } else {
                $innerHtml .= $slotContent;
            }
        }

        return $innerHtml;
    }

    /**
     * Renders component.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        $this->build();

        $renderString = "<" . $this->getComponent();

        if ($attributes = $this->toVueAttributes()) {
            $renderString .= " " . $attributes;
        }

        $renderString .= ">";

        if ($innerHtml = $this->renderInner()) {
            $renderString .= $innerHtml;
        }

        $renderString .= "</" . $this->getComponent() . ">";

        return new HtmlString($renderString);
    }
}
