<?php

namespace LegoCMS\Tests\Unit;

use LegoCMS\Core\Component;

class ComponentTest extends TestCase
{
    public $component;

    /**
     * @test
     */
    public function test_instance_throws_error_if_component_property_is_undefined()
    {
        $this->expectException('Exception');
        $this->component = $this->demoComponentClassWithoutComponentProperty();

        $this->component->getComponent();
    }

    public function test_instance_returns_component_name()
    {
        $this->component = $this->demoComponentClass();

        $this->assertEquals(
            "demo-component",
            $this->component->getComponent()
        );
    }

    public function test_instance_renders_component()
    {
        $this->component = $this->demoComponentClass();

        $this->assertEquals(
            "<demo-component></demo-component>",
            $this->component->render()
        );
    }

    private function demoComponentClassWithoutComponentProperty()
    {
        return new class extends Component
        {
            protected function prepareVueAttributes(): array
            {
                return [];
            }
        };
    }

    private function demoComponentClass()
    {
        return new class extends Component
        {
            protected $component = "demo-component";

            protected function prepareVueAttributes(): array
            {
                return [];
            }
        };
    }
}
