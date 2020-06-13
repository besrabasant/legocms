<?php

namespace LegoCMS\Tests\Unit;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return ['LegoCMS\Providers\LegoCMSServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('legocms.admin_app_url', 'http://localhost');
        $app['config']->set('legocms.admin_app_path', '/admin');
    }
}
