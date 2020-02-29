<?php

namespace LegoCMS\Tests\Unit;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return ['LegoCMS\Providers\LegoCMSServiceProvider'];
    }
}
