<?php


namespace LegoCMS\Tests\Behaviours;

use Laravel\Dusk\Browser;
use LegoCMS\Models\User;

/**
 * Trait ActsAsSuperAdmin
 * @package LegoCMS\Tests\Behaviours
 */
trait ActsAsSuperAdmin
{
    public $superAdmin;

    /**
     * @return void
     */
    public function createSuperAdmin()
    {
        $this->superAdmin = User::create([
            'name' => "John Doe",
            'email' => 'doejohn@gmail.com',
            'role' => 'SUPERADMIN',
            'published' => true,
        ]);

        $this->superAdmin->password = bcrypt('password');

        $this->superAdmin->save();
    }

    /**
     * @return $this
     */
    public function actingAsSuperAdmin()
    {
        return $this->actingAs($this->superAdmin, 'legocms_users');
    }

    /**
     * @param  Browser  $browser
     *
     * @return  Browser
     */
    public function loginAsSuperAdmin(Browser $browser)
    {
        return $browser->loginAs($this->superAdmin, 'legocms_users');
    }
}
