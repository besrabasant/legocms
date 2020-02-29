<?php

namespace LegoCMS\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LegoCMS\Models\Enums\UserRoles;
use LegoCMS\Models\User;
use LegoCMS\Tests\Behaviours\ActsAsSuperAdmin;

class UsersTest extends TestCase
{
    use RefreshDatabase, ActsAsSuperAdmin;

    /**
     * @test
     *
     * @return void
     */
    public function testSuperAdminCanCreateAnotherUser()
    {
        $response = $this->createDemoUser([
            'name' => 'Tony Stark',
            'email' => 'tonystark@gmail.com'
        ]);

        $response->assertHeader('Turbolinks-Location', \route('legocms.users.index'));

        $user = User::all()->last();

        $this->assertEquals('Tony Stark', $user->name);
        $this->assertEquals('tonystark@gmail.com', $user->email);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testSuperAdminCanUpdateUser()
    {
        $this->createDemoUser([
            'name' => 'Tony Stark',
            'email' => 'tonystark@gmail.com'
        ]);

        $user = User::where('email', 'tonystark@gmail.com')->first();

        $this->actingAsSuperAdmin()
            ->put(
                route(
                    'legocms.users.update',
                    ['user' => $user->id]
                ),
                [
                    'name' => 'Anthony Stark',
                    'email' => 'tonystark@gmail.com',
                    'role' => UserRoles::VISITOR
                ]
            );

        $user = User::all()->last();

        $this->assertEquals('Anthony Stark', $user->name);
        $this->assertNotEquals('Tony Stark', $user->name);
    }

    /**
     * @test
     *
     * @return void
     */
    public function testSuperAdminCanDeleteUser()
    {
        $this->createDemoUser([
            'name' => 'Tony Stark',
            'email' => 'tonystark@gmail.com'
        ]);

        $this->actingAsSuperAdmin()
            ->get(route('legocms.users.index'))
            ->assertSee('Tony Stark');

        $user = User::where('email', 'tonystark@gmail.com')->first();

        $this->delete(\route('legocms.users.destroy', ['user' => $user->id]));

        $users = User::all();

        $this->assertFalse($users->contains('name', 'Tony Stark'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createSuperAdmin();
    }

    protected function createDemoUser(array $user)
    {
        return $this->actingAsSuperAdmin()
            ->post(
                \route('legocms.users.store'),
                \array_merge(
                    $user,
                    ['role' => UserRoles::VISITOR]
                )
            );
    }
}
