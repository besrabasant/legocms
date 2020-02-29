<?php

namespace LegoCMS\Tests\Behaviours;

use LegoCMS\Support\Facades\LegoCMS;

/**
 * trait ManagesLegoSets
 *
 * @package LegoCMS\Tests\Behaviours
 */
trait ManagesLegoSets
{
    protected function getPackageProviders($app)
    {
        return array_merge(
            parent::getPackageProviders($app),
            [
                "DemoSet1\Providers\ServiceProvider"
            ]
        );
    }
}
