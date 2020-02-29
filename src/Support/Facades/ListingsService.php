<?php

namespace LegoCMS\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ListingsService Facade
 *
 * @category Facades
 * @package  LegoCMS\Support\Facades
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Support/Facades/ListingsService.php
 */
class ListingsService extends Facade
{
    /**
     * Facade Accessor.
     *
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return "legocms::services.listings";
    }
}
