<?php

namespace LegoCMS\Core\Behaviors;

trait HasVueAttributes
{
    abstract protected function prepareVueAttributes(): array;

    private function vueBindings()
    {
        return $this->vueBindings ?? [];
    }

    public function toVueAttributes($asArray = false)
    {
        $attributesArray = $this->prepareVueAttributes();

        if ($asArray) {
            return $attributesArray;
        }

        $attributesString = "";

        foreach ($attributesArray as $attrName => $attrValue) {
            // Check if attributes is in Vue bindings array.
            if (\in_array($attrName, $this->vueBindings())) {
                $attributesString .= ":";
            }

            // Convert Boolean value to string.
            if (is_bool($attrValue)) {
                if (substr($attributesString, -1) !== ":") {
                    $attributesString .= ":";
                }

                $attrValue = var_export($attrValue, true);
            }


            // Convert array value to json.
            if (is_array($attrValue)) {
                $attrValue = json_encode($attrValue);
            }

            $attributesString .= "{$attrName}=\"{$attrValue}\" ";
        }

        return rtrim($attributesString);
    }
}
