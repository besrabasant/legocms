<?php

namespace LegoCMS\Core\View;

use LegoCMS\Core\Component;

class AppShell extends Component
{
    protected $component = "legocms-shell";

    protected $slots = [];

    protected function prepareVueAttributes(): array
    {
        return [];
    }

    /**
     * TODO: Move this feature to component.
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

    protected function renderInner(): string
    {
        $innerHtml = "";

        foreach ($this->slots as $slotName => $slotComponents) {

            $slotContent = "";

            foreach ($slotComponents as $component) {
                $slotContent .= $component->render();
            }

            if ($slotName != 'default') {
                $innerHtml .= "<template #" . $slotName . ">" . $slotContent . "</template>";
            } else {
                $innerHtml .= $slotContent;
            }
        }

        return $innerHtml;
    }
}
