<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    protected $username;

    public function __construct()
    {
        $this->redirectTo = '/'. env('ADMIN_PREFIX');
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function guard()
    {
        return auth()->guard('admin');
    }

    public function logout()
    {
        $this->guard('admin')->logout();

        /*request()->session()->flush();

        request()->session()->regenerate();*/

        return redirect('/'.env('ADMIN_PREFIX').'/login');
    }

}
