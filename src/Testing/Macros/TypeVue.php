<?php

namespace LegoCMS\Testing\Macros;

/**
 * Class TypeVue.
 *
 * @mixin    \Laravel\Dusk\Browser
 * @category Macros
 * @package  LegoCMS\Testing\Macros
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Testing/Macros/TypeVue.php
 */
class TypeVue
{

    /**
     * Invokes class call.
     *
     * @return \Closure
     */
    public function __invoke()
    {
        /**
         * Types into VueJS input element.
         *
         * @param  string $element
         * @param  string $value
         * @mixin  \Laravel\Dusk\Browser
         *
         * @return \Laravel\Dusk\Browser
         */
        return function ($element = null, $value = "") {
            $selector = '#' .  $element;
            return $this->waitFor($selector)
                ->type($element, $value);
        };
    }
}
