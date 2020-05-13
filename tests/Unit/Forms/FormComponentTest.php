<?php

namespace LegoCMS\Tests\Unit\Forms;

use DemoSet1\Modules\DemoModule;
use LegoCMS\Tests\Unit\TestCase;
use LegoCMS\Forms\Form;
use Mockery;

class FormComponentTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = Mockery::mock(DemoModule::make());
    }

    /**
     * @test
     */
    public function test_form_renders()
    {
        $this->mock->shouldReceive('getRoute')
            ->with("create")
            ->andReturn('/demo-module');

        $component = Form::make("form", $this->mock);

        $this->assertEquals(
            '<legocms-form method="POST" action-url="/demo-module"></legocms-form>',
            $component->render()
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

        $component->forAction("UPDATE");

        $this->assertEquals(
            '<legocms-form method="PUT" action-url="/demo-module"></legocms-form>',
            $component->render()
        );
    }
}
