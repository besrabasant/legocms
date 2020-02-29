<?php

namespace LegoCMS\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LegoCMS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class LoginController
 *
 * @package LegoCMS\Http\Controllers\Admin\Auth
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('legocms_guest')->except(['logout']);
        $this->redirectTo = config('legocms.auth_login_redirect_path', '/');
    }

    /**
     * showLoginForm
     *
     * @return  \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('legocms::auth.login');
    }

    /**
     * guard
     *
     * @return void
     */
    protected function guard()
    {
        return Auth::guard('legocms_users');
    }

    /**
     * @param Request $request
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return $this->loggedOut($request) ?: redirect()->route('legocms.admin.login');
    }
}
