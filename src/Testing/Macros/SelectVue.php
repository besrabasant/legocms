<?php

namespace LegoCMS\Testing\Macros;

/**
 * Class SelectVue.
 *
 * @mixin    \Laravel\Dusk\Browser
 * @category Macros
 * @package  LegoCMS\Testing\Macros
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Testing/Macros/SelectVue.php
 */
class SelectVue
{

    /**
     * Invokes class call.
     *
     * @return \Closure
     */
    public function __invoke()
    {
        /**
         * Selects option from VueJS select element.
         *
         * @param  string $element
         * @param  string $value
         * @mixin  \Laravel\Dusk\Browser
         *
         * @return  \Laravel\Dusk\Browser
         */
        return function ($element = null, $value = "") {
            $selector = '#' .  $element;
            return $this->waitFor($selector)
                ->select($element, $value);
        };
    }
}
