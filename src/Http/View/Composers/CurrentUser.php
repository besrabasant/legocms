<?php

namespace LegoCMS\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class CurrentUser
 *
 * @package LegoCMS\Http\View\Composers
 */
class CurrentUser
{
    /**
     * compose
     *
     * @param  Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $currentUser = Auth::guard('legocms_users')->user();
        $view->with('currentUser', $currentUser);
    }
}
