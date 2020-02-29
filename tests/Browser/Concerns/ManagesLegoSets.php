<?php

namespace LegoCMS\Tests\Browser\Concerns;

use LegoCMS\Support\Facades\LegoCMS;

/**
 * trait ManagesLegoSets
 *
 * @package LegoCMS\Tests\Browser\Concerns
 */
trait ManagesLegoSets
{
    protected $demoModules = [
        'demoset1'
    ];

    public function addLegoSets()
    {
        LegoCMS::addLegoSet('demoset1', [
            'namespace' => "DemoSet1",
            'package_root' => __DIR__ . "/../../Fixtures/demo_set_1",
            'routes_dir' => __DIR__ . "/../../Fixtures/demo_set_1/routes"
        ]);
    }
}
