<?php

namespace LegoCMS\Tests\Browser;

use Laravel\Dusk\Browser;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Behaviours\ManagesLegoSets;

/**
 * Class LegoSetsTest
 *
 * @package LegoCMS\Tests\Browser
 */
class LegoSetsTest extends DuskTestCase
{
    use ActsAsSuperAdmin, ManagesLegoSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    /** @test */
    public function testUserCanSeeRegistedLegoSetLink()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/dashboard')
                ->assertSeeLink('Articles');
        });
    }
}
