<?php

namespace LegoCMS\Tests\Unit;

use LegoCMS\Core\Behaviors\HasVueAttributes;

class VueComponentTest extends TestCase
{
    public $classWithVueAttributes;

    /**
     * @test
     */
    public function test_instance_can_return_vue_attributes_as_string()
    {
        $this->classWithVueAttributes = $this->demoVueComponentClass();

        $attributes = $this->classWithVueAttributes->toVueAttributes();

        $this->assertEquals(
            'prop-1="prop 1 value" prop-2="prop 2 value" prop-3="prop 3 value"',
            $attributes
        );
    }

    /**
     * @test
     */
    public function test_instance_can_return_vue_attributes_as_array()
    {
        $this->classWithVueAttributes = $this->demoVueComponentClass();

        $attributes = $this->classWithVueAttributes->toVueAttributes(true);

        $this->assertEquals(
            [
                'prop-1' => "prop 1 value",
                'prop-2' => "prop 2 value",
                'prop-3' => "prop 3 value",
            ],
            $attributes
        );
    }

    /**
     * @test
     */
    public function test_instance_can_return_boolean_vue_attributes_as_string()
    {
        $this->classWithVueAttributes = $this->demoVueComponentClassWithBooleanAttribute();

        $attributes = $this->classWithVueAttributes->toVueAttributes();

        $this->assertEquals(
            'prop-1="prop 1 value" prop-2="prop 2 value" :prop-3="true"',
            $attributes
        );
    }

    /**
     * @test
     */
    public function test_instance_can_return_vue_attributes_with_bindings()
    {
        $this->classWithVueAttributes = $this->demoVueComponentClassWithBindings();

        $attributes = $this->classWithVueAttributes->toVueAttributes();

        $this->assertEquals(
            ':prop-1="prop 1 value" prop-2="prop 2 value" prop-3="prop 3 value"',
            $attributes
        );
    }


    /**
     * @test
     */
    public function test_instance_can_return_vue_attributes_array_value_with_bindings_as_json()
    {
        $this->classWithVueAttributes = $this->demoVueComponentClassWithArrayAttributes();

        $attributes = $this->classWithVueAttributes->toVueAttributes();

        $this->assertEquals(
            'prop-1="prop 1 value" ' .
                ':prop-2="{"key1":"value1","key2":"value2","key3":"value3"}" ' .
                'prop-3="prop 3 value"',
            $attributes
        );
    }


    private function demoVueComponentClass()
    {
        return new class
        {
            use HasVueAttributes;

            protected function prepareVueAttributes(): array
            {
                return [
                    'prop-1' => "prop 1 value",
                    'prop-2' => "prop 2 value",
                    'prop-3' => "prop 3 value",
                ];
            }
        };
    }

    private function demoVueComponentClassWithBooleanAttribute()
    {
        return new class
        {
            use HasVueAttributes;

            protected function prepareVueAttributes(): array
            {
                return [
                    'prop-1' => "prop 1 value",
                    'prop-2' => "prop 2 value",
                    'prop-3' => true
                ];
            }
        };
    }

    private function demoVueComponentClassWithBindings()
    {
        return new class
        {
            use HasVueAttributes;

            protected $vueBindings = [
                'prop-1'
            ];

            protected function prepareVueAttributes(): array
            {
                return [
                    'prop-1' => "prop 1 value",
                    'prop-2' => "prop 2 value",
                    'prop-3' => "prop 3 value",
                ];
            }
        };
    }


    private function demoVueComponentClassWithArrayAttributes()
    {
        return new class
        {
            use HasVueAttributes;

            protected $vueBindings = [
                'prop-2'
            ];

            protected function prepareVueAttributes(): array
            {
                return [
                    'prop-1' => "prop 1 value",
                    'prop-2' => ["key1" => "value1", "key2" => "value2", "key3" => "value3"],
                    'prop-3' => "prop 3 value",
                ];
            }
        };
    }
}
