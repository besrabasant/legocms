<?php

namespace LegoCMS\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use LegoCMS\Support\Facades\LegoCMS;
use LegoCMS\Support\Facades\MenuService;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;
use LegoCMS\Tests\TestMessage;

class LegoSetsTest extends TestCase
{
    use RefreshDatabase, ActsAsSuperAdmin, ManagesLegoSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    /**
     * @test
     */
    public function testDemoLegoSetIsAddedToLegoSetsConfig()
    {
        $legoSets = LegoCMS::all();

        $this->assertTrue($legoSets->has("demoset1"));
    }

    /**
     * @test
     */
    public function testDemoLegoSetRoutesAreRegistered()
    {
        $this->markTestSkipped(TestMessage::NEEDS_REWRITE);

        $routes = collect(Route::getRoutes())->mapWithKeys(function ($route) {
            return [$route->getName() => $route->uri()];
        })->collect();

        $demoRoutes = [
            "legocms.articles.preview" => "articles/{article}/preview",
            "legocms.articles.publish" => "articles/{article}/publish",
            "legocms.articles.feature" => "articles/{article}/feature",
            "legocms.articles.restore" => "articles/{article}/restore",
            "legocms.articles.forceDelete" => "articles/{article}/force-delete",
            "legocms.articles.restoreRevision" => "articles/{article}/revision/{revision}",
            "legocms.articles.previewRevision" => "articles/{article}/revision/{revision}",
            "legocms.articles.deleteRevision" => "articles/{article}/revision/{revision}",

            "legocms.articles.index" => 'articles',
            "legocms.articles.create" => 'articles/create',
            "legocms.articles.store" => 'articles',
            "legocms.articles.show" => 'articles/{article}',
            "legocms.articles.edit" => 'articles/{article}',
            "legocms.articles.update" => "articles/{article}",
            "legocms.articles.destroy" => "articles/{article}",
        ];


        foreach ($demoRoutes as $routeName => $routeUri) {
            $this->assertTrue($routes->has($routeName));
            $this->assertTrue($routes->contains($routeUri));
        }
    }

    /**
     * @test
     */
    public function testDemoModuleNavigationsAreRegistered()
    {
        $menus = MenuService::buildGlobalMenu();

        $this->assertTrue(
            in_array(
                'articles',
                Arr::pluck($menus, 'key')
            )
        );
    }
}
