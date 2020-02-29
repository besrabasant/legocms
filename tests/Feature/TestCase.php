<?php

namespace LegoCMS\Tests\Feature;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $setupCommands = [
        ['vendor:publish', ['--provider' => 'LegoCMS\\Providers\\LegoCMSServiceProvider', '--tag' => 'assets']],
        ['vendor:publish', ['--provider' => 'LegoCMS\\Providers\\LegoCMSServiceProvider', '--tag' => 'translatable']]
    ];

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->runSetupCommands();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return ['LegoCMS\Providers\LegoCMSServiceProvider'];
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
