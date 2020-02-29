<?php

namespace LegoCMS\Tests\Browser;

use Laravel\Dusk\Browser;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;
use LegoCMS\Tests\Browser\Pages\Auth;

/**
 * Class LoginTest
 * @package LegoCMS\Tests\Browser
 */
class LoginTest extends DuskTestCase
{
    use ActsAsSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    /**
     * @test
     */
    public function testVisitorCanSeeLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('admin/login')
                ->assertSee('Login');
        });
    }

    /**
     * @test
     */
    public function testARegisteredUserCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Auth())
                ->doLogin($this->superAdmin->email)
                ->assertAuthenticatedAs($this->superAdmin, 'legocms_users');
        });
    }

    /**
     * @test
     */
    public function testLoggedInUserCanLogout()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/dashboard')
                ->assertSeeLink('Logout')
                ->clickLink("Logout")
                ->patchedAssertPathIs('/admin/login')
                ->assertSee("Login")
                ->assertDontSee("Logout");
        });
    }
}
