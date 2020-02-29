<?php

namespace LegoCMS\Tests\Feature;

use DemoSet1\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;

class RevisionsTest extends TestCase
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
    public function testRevisionsCanBeCreated()
    {
        $data = $this->demoData();

        $this->actingAsSuperAdmin()
            ->post(
                \route('legocms.articles.store'),
                $data
            );

        $article = Article::all()->first();

        $this->assertEquals(1, $article->revisions->count());

        // We make some updates.
        $updated = $this->updatedData();

        $this->actingAsSuperAdmin()
            ->put(
                \route(
                    'legocms.articles.update',
                    ['article' => $article->id]
                ),
                $updated
            );

        $articleUpdated = Article::all()->first();

        $revision = $articleUpdated->revisions->first();

        $hydrated = $articleUpdated->hydrateRevision($revision);

        $this->assertEquals(2, $articleUpdated->revisions->count());

        // Hydrated model from revision is equal to the old data.
        $this->assertEquals($data['en']['name'], $hydrated->translate('en')->name);

        // Hydated model from revision is not equal to the updated data.
        $this->assertNotEquals($updated['en']['name'], $hydrated->translate('en')->name);

        // Updated model from revision is equal to the updated data.
        $this->assertEquals($updated['en']['name'], $articleUpdated->translate('en')->name);
    }


    /**
     * @test
     *
     * @return void
     */
    public function testRevisionsCanBeRestored()
    {
        $data = $this->demoData();

        $this->actingAsSuperAdmin()
            ->post(
                \route('legocms.articles.store'),
                $data
            );

        $article = Article::all()->first();

        // We make some updates.
        $updated = $this->updatedData();

        $this->actingAsSuperAdmin()
            ->put(
                \route(
                    'legocms.articles.update',
                    ['article' => $article->id]
                ),
                $updated
            );

        $articleUpdated = Article::all()->first();

        $revision = $articleUpdated->revisions->first();

        // We Restore the Revision.
        $this->actingAsSuperAdmin()
            ->put(
                \route(
                    'legocms.articles.restoreRevision',
                    ['article' => $article->id, 'revision' => $revision->id]
                )
            );

        $restored = Article::all()->first();

        $this->assertEquals(2, $restored->revisions->count());

        // Restored model from revision is equal to the old data.
        $this->assertEquals($data['en']['name'], $restored->translate('en')->name);

        // Restored model from revision is not equal to the updated data.
        $this->assertNotEquals($updated['en']['name'], $restored->translate('en')->name);
    }


    /**
     * @test
     *
     * @return void
     */
    public function testRevisionsCanBeDeleted()
    {
        $data = $this->demoData();

        $this->actingAsSuperAdmin()
            ->post(
                \route('legocms.articles.store'),
                $data
            );

        $article = Article::all()->first();

        $this->assertEquals(1, $article->revisions->count());

        // We make some updates.
        $updated = $this->updatedData();

        $this->actingAsSuperAdmin()
            ->put(
                \route(
                    'legocms.articles.update',
                    ['article' => $article->id]
                ),
                $updated
            );


        $articleUpdated = Article::all()->first();

        $this->assertEquals(2, $articleUpdated->revisions->count());

        $revision = $articleUpdated->revisions->first();

        // We delete the revision.
        $this->actingAsSuperAdmin()
            ->delete(
                \route(
                    'legocms.articles.deleteRevision',
                    ['article' => $article->id, 'revision' => $revision->id]
                )
            );

        $afterDeletedRevision = Article::all()->first();

        $this->assertEquals(1, $afterDeletedRevision->revisions->count());
    }

    protected function updatedData()
    {
        $data = $this->demoData();

        $updated = $data;

        $updated['en'] = [
            'name' => 'Category 1 (en-US)',
            'description' => 'Category 1 Description (en-US)',
            'active' => true
        ];

        return $updated;
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
