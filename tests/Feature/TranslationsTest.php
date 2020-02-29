<?php

namespace LegoCMS\Tests\Feature;

use DemoSet1\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;

class TranslationsTest extends TestCase
{
    use RefreshDatabase, ActsAsSuperAdmin, ManagesLegoSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    /**
     * @test
     *
     * @return void
     */
    public function testTranslationsCanBeCreated()
    {
        $data = $this->demoData();

        $response = $this->actingAsSuperAdmin()
            ->post(
                \route('legocms.articles.store'),
                $data
            );

        $translations = [
            'en',
            'fr'
        ];

        $article = Article::all()->first();

        $this->assertEquals($data['author'], $article->author);
        $this->assertEquals($data['email'], $article->email);

        foreach ($translations as $t) {
            $this->assertEquals($data[$t]['name'], $article->translate($t)->name);
            $this->assertEquals($data[$t]['description'], $article->translate($t)->description);
            $this->assertEquals($data[$t]['active'], boolval($article->translate($t)->active));
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function testTranslationsCanBeUpdated()
    {

        $data = $this->demoData();

        $translations = [
            'en',
            'fr'
        ];

        $article = Article::create($data);

        $updated = $data;

        $updated['fr'] = [
            'name' => 'Category 1 (fr-FR)',
            'description' => 'Category 1 Description (fr-FR)',
            'active' => true
        ];

        $this->actingAsSuperAdmin()
            ->put(
                \route(
                    'legocms.articles.update',
                    ['article' => $article->id]
                ),
                $updated
            );

        $articleUpdated = Article::find($article->id);

        foreach ($translations as $t) {
            $this->assertEquals($updated[$t]['name'], $articleUpdated->translate($t)->name);
            $this->assertEquals($updated[$t]['description'], $articleUpdated->translate($t)->description);
            $this->assertEquals($updated[$t]['active'], boolval($articleUpdated->translate($t)->active));
        }
    }


    protected function demoData()
    {
        return [
            'author' => 'John Doe',
            'email' => 'johdoe@gmail.com',
            'en' => [
                'name' => 'Category 1',
                'description' => 'Category 1 Description',
                'active' => true,
            ],
            'fr' => [
                'name' => 'Category 1 (French)',
                'description' => 'Category 1 Description (French)',
                'active' => false
            ]
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetup($app);
        $app['config']->set('translatable.locales', [
            'en',
            'fr'
        ]);
    }
}
