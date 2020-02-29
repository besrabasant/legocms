<?php


namespace LegoCMS\Tests\Browser;

use Laravel\Dusk\Browser;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;

/**
 * Class DashboardTest
 *
 * @package LegoCMS\Tests\Browser
 */
class DashboardTest extends DuskTestCase
{
    use ActsAsSuperAdmin;

    public function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    /**
     * @test
     */
    public function testAuthenticatedUserCanAccessDashboard()
    {
        //$this->markTestSkipped('Test is Ok');

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->superAdmin, 'legocms_users')
                ->visit('/admin/dashboard')
                ->assertSee('Dashboard');
        });
    }
}
