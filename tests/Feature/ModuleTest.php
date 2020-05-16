<?php

namespace LegoCMS\Tests\Feature;

use DemoSet1\Modules\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use LegoCMS\Core\Actions\CreateAction;
use LegoCMS\Core\Actions\StoreAction;
use LegoCMS\Core\Actions\UpdateAction;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;
use Mockery;

class ModuleTest extends TestCase
{
    use RefreshDatabase, ActsAsSuperAdmin, ManagesLegoSets;

    private $requestMock;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_instance_can_resolve_action_from_request()
    {
        $this->setUpMock();

        $module = Article::make();

        $action  = $module->resolveActionFromRequest($this->requestMock);

        $this->assertInstanceOf(CreateAction::class, $action);

        $this->setUpMock("lego.article.update");

        $action  = $module->resolveActionFromRequest($this->requestMock);

        $this->assertInstanceOf(UpdateAction::class, $action);
    }

    private function setUpMock($routeName = 'legocms.articles.create')
    {
        $mockRoute = Mockery::mock(Route::getFacadeRoot());
        $mockRoute->shouldReceive('getName')->andReturn($routeName);
        $this->requestMock = Mockery::mock(Request::getFacadeRoot());
        $this->requestMock->shouldReceive('route')->andReturn($mockRoute);
    }
}
