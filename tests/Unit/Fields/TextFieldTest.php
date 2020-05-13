<?php

namespace LegoCMS\Tests\Unit\Fields;

use LegoCMS\Tests\Unit\TestCase;
use LegoCMS\Forms\Fields\TextField;

class TextFieldTest extends TestCase
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
}
