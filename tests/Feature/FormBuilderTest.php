<?php

namespace LegoCMS\Tests\Feature;

use DemoSet1\Modules\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use LegoCMS\Core\Actions\StoreAction;
use LegoCMS\Forms\FormBuilder;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;

class FormBuilderTest extends TestCase
{
    use RefreshDatabase, ActsAsSuperAdmin, ManagesLegoSets;

    protected function setUp(): void
    {
        parent::setUp();

        Session::shouldReceive('token')
            ->andReturn('csrf_token');
    }

    public function test_instance_can_build_form_from_module_instance()
    {
        $module = Article::make();

        $instance = FormBuilder::make($module);

        $instance->forAction(StoreAction::make($module))
            ->build();

        $expected = '<legocms-form name="article-store" method="POST" ' .
            'action-url="http://localhost/admin/articles" token="csrf_token">' . PHP_EOL .
            "\t" . '<id-field value=""></id-field>' . PHP_EOL .
            '</legocms-form>';

        $this->assertEquals(
            $expected,
            $instance->form()->render()->toHtml()
        );
    }
}
