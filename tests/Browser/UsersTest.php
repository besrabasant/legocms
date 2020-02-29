<?php


namespace LegoCMS\Tests\Browser;

use Laravel\Dusk\Browser;
use LegoCMS\Models\User;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;

/**
 * Class UsersTest
 * @package LegoCMS\Tests\Browser
 */
class UsersTest extends DuskTestCase
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
    public function testSuperAdminCanSeeEmptyRecordsWhenNoRecordsInDatabase()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users')
                ->assertSee('Empty Records');
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanSeeCreateUserLink()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users')
                ->assertSeeLink('Create User');
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanSeeCreateUserForm()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users/create')
                ->pause(2000)
                ->assertSee('Create User')
                ->assertSourceHas('Name')
                ->assertSourceHas('Email')
                ->assertSourceHas('Role');
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanCreateNewUser()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users/create')
                ->pause(2000)
                ->typeVue('name', 'Peter Parker')
                ->typeVue('email', 'pparker@gmail.com')
                ->selectVue('role', 'VISITOR')
                ->press('Create')
                ->pause(2000)
                ->visit('/admin/users')
                ->assertSee("Peter Parker");
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanUpdateUser()
    {
        $user = $this->createDemoUser();

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users')
                ->assertSee("Peter Parker")
                ->pause(2000)
                ->clickLink('Edit', '#editUser__' . $user->id)
                ->pause(1000)
                ->typeVue('name', 'Tom Holland')
                ->press('Update')
                ->pause(2000)
                ->assertDontSee("Peter Parker")
                ->assertSee("Tom Holland");
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanSeeConfirmationBeforeDeletingUser()
    {
        $user = $this->createDemoUser();

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users')
                ->assertSee("Peter Parker")
                ->pause(1000)
                ->clickLink('Delete', '#deleteUser__' . $user->id)
                ->whenAvailable('[data-modal="delete-confirmation"]', function ($modal) {
                    $modal->assertSee('Delete User');
                    $modal->assertSee('Yes');
                    $modal->assertSee('No');
                });
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanDeleteUser()
    {
        $user = $this->createDemoUser();

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users')
                ->assertSee("Peter Parker")
                ->pause(1000)
                ->clickLink('Delete', '#deleteUser__' . $user->id)
                ->whenAvailable('[data-modal="delete-confirmation"]', function ($modal) {
                    $modal->press('Yes');
                })
                ->pause(3000)
                ->assertDontSee("Peter Parker");
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCanReturnToUsersListingsOnClickingCancelFromUpdateScreen()
    {
        $user = $this->createDemoUser();

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAsSuperAdmin($browser)
                ->visit('/admin/users/' . $user->id . "/edit")
                ->assertSee("Cancel")
                ->clickLink('Cancel')
                ->pause(2000)
                ->patchedAssertPathIs('/admin/users');
        });
    }

    /**
     * @test
     */
    public function testSuperAdminCannotSeeHimselfInUserListings()
    {
        $this->browse(function (Browser $browser) {
            $this->loginAsSuperAdmin($browser)
                ->visit("/admin/users/")
                ->assertDontSeeIn('.listings', $this->superAdmin->name);
        });
    }


    private function createDemoUser()
    {
        return User::create([
            'name' => 'Peter Parker',
            'email' => 'pparker@gmail.com',
            'role' => 'VISITOR',
            'published' => true
        ]);
    }

    private function createAdminDemoUser()
    {
        return User::create([
            'name' => 'Bilbo Baggins',
            'email' => 'bbaggins@gmail.com',
            'role' => 'ADMIN',
            'published' => true
        ]);
    }
}
