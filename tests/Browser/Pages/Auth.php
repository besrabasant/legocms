<?php


namespace LegoCMS\Tests\Browser\Pages;


use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Auth extends Page
{
    /**
     * @inheritDoc
     */
    public function url()
    {
        return '/admin/login';
    }

    public function doLogin(Browser $browser, $email)
    {
        $browser->type('email', $email)
            ->type('password', 'password')
            ->press('Login');
    }
}