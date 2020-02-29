<?php

namespace LegoCMS\Http\Controllers\Admin;

use LegoCMS\Http\Controllers\Controller;

/**
 * Class DashboardController
 *
 * @package LegoCMS\Http\Controllers
 */
class DashboardController extends Controller
{
    public function index()
    {
        return view('legocms::admin.dashboard');
    }
}
