<?php

namespace LegoCMS\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * class LegoCMS.
 *
 * @category Facades
 * @package  LegoCMS\Support\Facades
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Support/Facades/LegoCMS.php
 *
 * @method  void  addLegoSet(string $legoSetKey, array $legoSetConfig)
 * @method  \LegoCMS\Services\LegoSet  get(string $legoSetKey)
 * @method  \LegoCMS\Services\LegoSetsRepository  all()
 */
class LegoCMS extends Facade
{
    /**
     * Returns FacadeAccessor.
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return 'legocms';
    }
}
