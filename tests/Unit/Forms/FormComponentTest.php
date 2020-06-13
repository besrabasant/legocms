<?php

namespace LegoCMS\Tests\Unit\Forms;

use DemoSet1\Modules\Article;
use Illuminate\Support\Facades\Session;
use LegoCMS\Core\Actions\UpdateAction;
use LegoCMS\Fields\ID;
use LegoCMS\Tests\Unit\TestCase;
use LegoCMS\Forms\Form;
use LegoCMS\Forms\FormFields;
use Mockery;

class FormComponentTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = Mockery::mock(Article::make());
        Session::shouldReceive('token')->andReturn('csrf_token');
    }

    /**
     * @test
     */
    public function test_form_renders()
    {
        $this->mock->shouldReceive('getRoute')
            ->with("store")
            ->andReturn('/demo-module');

        $component = Form::make("form", $this->mock);

        $this->assertEquals(
            '<legocms-form name="form" method="POST" action-url="/demo-module" token="csrf_token"></legocms-form>',
            $component->render()->toHtml()
        );
    }

    /**
     * @test
     */
    public function test_form_renders_for_action()
    {
        $this->mock->shouldReceive('getRoute')
            ->with("update")
            ->andReturn('/demo-module');

        $component = Form::make("form", $this->mock);

        $component->forAction(UpdateAction::make($this->mock));

        $this->assertEquals(
            '<legocms-form name="form" method="PUT" action-url="/demo-module" token="csrf_token"></legocms-form>',
            $component->render()
        );
    }

    /**
     * @test
     */
    public function test_form_can_render_fields()
    {
        $this->mock->shouldReceive('getRoute')
            ->andReturn('/demo-module');

        $component = Form::make("form", $this->mock);

        $component->setFormFields(FormFields::make([
            ID::make()
        ]));

        $expected = '<legocms-form name="form" method="POST" action-url="/demo-module" token="csrf_token">' .
            '<id-field value=""></id-field>' .
            '</legocms-form>';

        $this->assertEquals(
            $expected,
            $component->render()
        );
    }
}
