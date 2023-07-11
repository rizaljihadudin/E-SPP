<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login_sneat');
    }

    public function showLoginFormWali()
    {
        return view('auth.login_sneat_wali');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->akses == 'operator' || $user->akses == 'admin') {
            return redirect()->route('operator.beranda');
        } elseif ($user->akses == 'wali') {
            return redirect()->route('wali.beranda');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('Anda tidak memiliki hak akses')->error();
        }
    }

    /** untuk melakukan login via link dari whatsapp */
    public function loginUrl(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $user = Auth::loginUsingId($request->user_id);

        return redirect($request->url);
    }
}
