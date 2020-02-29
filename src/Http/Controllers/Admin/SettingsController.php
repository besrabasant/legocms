<?php

namespace LegoCMS\Http\Controllers\Admin;

use Illuminate\View\View;

/**
 * Class SettingsController
 *
 * @package LegoCMS\Http\Controllers\Admin
 */
class SettingsController extends ModuleController
{

    /**
     * Controller show method.
     *
     * @return  View
     */
    public function showSettings()
    {
        return \view("legocms::settings.show");
    }
}
