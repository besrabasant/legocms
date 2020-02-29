<?php

namespace LegoCMS\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;

/**
 * Class DashboardTest
 * @package LegoCMS\Tests\Feature
 */
class DashboardTest extends TestCase
{

    use RefreshDatabase, ActsAsSuperAdmin;

    /**
     * Test Dashboard cannot be access with login.
     *
     * @return void
     */
    public function testDashboardCannotBeAccessedWithoutAuthentication()
    {
        $response = $this->get(route('legocms.dashboard'));

        $response->assertRedirect(route('legocms.admin.login.form'));
    }

    /**
     * @return void
     */
    public function testDashboardCanBeAccessedAsAuthenticatedUser()
    {
        $this->createSuperAdmin();

        $response = $this->actingAsSuperAdmin()
            ->get(route('legocms.dashboard'));

        $response->assertStatus(200);
    }
}
