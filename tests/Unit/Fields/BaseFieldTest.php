<?php

namespace LegoCMS\Tests\Unit\Fields;

use LegoCMS\Tests\Unit\TestCase;
use LegoCMS\Fields\TextField;

class BaseFieldTest extends TestCase
{
    /**
     * @test
     */
    public function test_instance_can_render_field()
    {
        $component = TextField::make("Name");

        $this->assertEquals(
            '<text-field label="Name" name="name" value=""></text-field>',
            $component->render()
        );
    }

    /**
     * @test
     */
    public function test_instance_can_render_field_using_computed_value()
    {
        $component = TextField::make("Name", function () {
            return "John Doe";
        });

        $this->assertEquals(
            '<text-field label="Name" name="name" value="John Doe"></text-field>',
            $component->render()->toHtml()
        );
    }
}
