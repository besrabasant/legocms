<?php

namespace LegoCMS\Testing\Macros;

use PHPUnit\Framework\Assert as PHPUnit;

/**
 * Class PatchedAssertPathIs.
 *
 * @mixin    \Laravel\Dusk\Browser
 * @category Macros
 * @package  LegoCMS\Testing\Macros
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Testing/Macros/PatchedAssertPathIs.php
 */
class PatchedAssertPathIs
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
         * Assert that the current URL path matches the given pattern.
         *
         * @param  string  $path
         * @mixin  \Laravel\Dusk\Browser
         *
         * @return  \Laravel\Dusk\Browser
         */
        return function ($path) {
            $pattern = str_replace('\*', '.*', preg_quote($path, '/'));

            $actualPath = parse_url($this->driver->getCurrentURL(), PHP_URL_PATH) ?? '';

            PHPUnit::assertMatchesRegularExpression(
                '/^' . $pattern . '$/u',
                $actualPath,
                "Actual path [{$actualPath}] does not equal expected path [{$path}]."
            );

            return $this;
        };
    }
}
