<?php

namespace LegoCMS\Tests\Unit\Fields;

use DemoSet1\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LegoCMS\Tests\Unit\TestCase;
use LegoCMS\Fields\ID;

class IDFieldTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_id_field_renders()
    {
        $component = ID::make();

        $component->setValue(1);

        $this->assertEquals(
            '<id-field value="1"></id-field>',
            $component->render()
        );
    }

    public function test_id_field_can_render_from_model()
    {

        $model = Article::make([
            "id" => 1,
            "name" => "test name",
            "description" => "Description",
        ]);

        $component = ID::fromModel($model);

        $this->assertEquals(
            '<id-field value="' . $model->id . '"></id-field>',
            $component->render()
        );
    }
}
