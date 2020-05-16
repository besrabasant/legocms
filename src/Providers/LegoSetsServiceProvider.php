<?php

namespace LegoCMS\Providers;

use LegoCMS\Core\Support\LegoAppServiceProvider;
use LegoCMS\Services\LegoSet;
use LegoCMS\Support\Facades\LegoCMS;

/**
 * Class LegoSetsServiceProvider
 *
 * @category ServiceProviders
 * @package  LegoCMS\Providers
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Providers/LegoSetsServiceProvider.php
 */
class LegoSetsServiceProvider extends LegoAppServiceProvider
{
    /**
     * Registers application services.
     *
     * @return  void
     */
    public function register()
    {
    }

    /**
     * Boots application services.
     *
     * @return  void
     */
    public function boot()
    {
        $this->registerLegoSetsConfigurations();
    }

    /**
     * Registers Configurations from registered LegoSets.
     *
     * @return  void
     */
    protected function registerLegoSetsConfigurations()
    {
        $legoSets = LegoCMS::all();

        $legoSets->each(function (LegoSet $legoSet) {

            if (\file_exists($legoSet->getPackageRoot() . 'config/modules.php')) {
                $this->mergeConfigFrom($legoSet->getPackageRoot() . 'config/modules.php', 'legocms.modules');
            }

            if (\file_exists($legoSet->getPackageRoot() . 'config/navigation.php')) {
                $this->mergeConfigFrom($legoSet->getPackageRoot() . 'config/navigation.php', 'legocms.navigation');
            }
        });
    }
}
