<?php

namespace LegoCMS\Tests;

use Orchestra\Testbench\Dusk\Options;
use Facebook\WebDriver\Chrome\ChromeOptions;

class DuskOptions extends Options
{
    public static function getChromeOptions()
    {
        return (new ChromeOptions())
            ->setExperimentalOption('w3c', false)
            ->addArguments(
                !static::hasUI() ? [
                    '--disable-gpu',
                    '--headless',
                ] : [
                    '--window-size=1920,1080'
                ]
            );
    }
}
