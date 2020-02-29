<?php

namespace LegoCMS\Tests\Browser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use LegoCMS\Tests\DuskOptions;
use Orchestra\Testbench\Dusk\TestCase as BaseTestCase;

/**
 * Class DuskTestCase
 * @package LegoCMS\Tests\Browser
 */
abstract class DuskTestCase extends BaseTestCase
{
    protected static $baseServeHost = '127.0.0.1';

    protected static $baseServePort = 8000;

    protected $setupCommands = [
        ['migrate:refresh', ['--database' => 'sqlite']],
        'clear-compiled',
        'view:clear',
        'cache:clear',
        ['vendor:publish', ['--provider' => 'LegoCMS\\Providers\\LegoCMSServiceProvider', '--tag' => 'assets']],
        ['vendor:publish', ['--provider' => 'LegoCMS\\Providers\\LegoCMSServiceProvider', '--tag' => 'translatable']]
    ];

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(\public_path('assets'));

        $this->runSetupCommands();
    }


    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set("database.default", "sqlite");
        $app['config']->set("database.connections.sqlite.database", database_path("database.sqlite"));
        $app['config']->set("session.driver", "file");
        $app['config']->set("app.debug", "true");
        $app['config']->set("legocms.admin_app_url", "http://" . static::$baseServeHost);
        $app['config']->set("legocms.admin_app_path", "/admin");
    }

    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['LegoCMS\Providers\LegoCMSServiceProvider'];
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                DuskOptions::getChromeOptions()
            )
        );
    }

    /**
     * Runs Artisan commands at setup.
     *
     * @return void
     */
    private function runSetupCommands()
    {
        foreach ($this->setupCommands as $command) {
            if (is_array($command)) {
                $this->artisan($command[0], $command[1])->run();
            } else {
                $this->artisan($command)->run();
            }
        }
    }
}
