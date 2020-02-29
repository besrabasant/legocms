<?php

namespace LegoCMS\Testing;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;
use LegoCMS\Testing\Macros\PatchedAssertPathIs;
use LegoCMS\Testing\Macros\SelectVue;
use LegoCMS\Testing\Macros\TypeVue;

/**
 * Class TestServiceProvider
 *
 * @category Testing
 * @package  LegoCMS\Testing
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Testing/TestServiceProvider.php
 */
class TestServiceProvider extends ServiceProvider
{
    /**
     * Boots Application Services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Registers Application services.
     *
     * @return void
     */
    public function register()
    {
        Browser::macro('typeVue', \app(TypeVue::class)());
        Browser::macro('selectVue', \app(SelectVue::class)());
        Browser::macro('patchedAssertPathIs', \app(PatchedAssertPathIs::class)());
    }
}
