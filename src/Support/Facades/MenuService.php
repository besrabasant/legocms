<?php

namespace LegoCMS\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MenuService Facade
 *
 * @category Facades
 * @package  LegoCMS\Support\Facades
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Support/Facades/MenuService.php
 */
class MenuService extends Facade
{
    /**
     * Facade Accessor.
     *
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return 'legocms::services.menu';
    }
}
