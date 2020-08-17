<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Helpers\Auth\Login;
use App\Helpers\Auth\Logout;

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
        $this->middleware('guest')->except('api_logout','logout');
    }

    /**
     * login
     * get a token
     * @return \Illuminate\Http\Response (JSON)
     */
    public function api_login(Request $request){
        $loginData = Login::create_token($request);
        return response()->json($loginData);
    }
    
    /**
     * logout
     * revoke a token
     * @return \Illuminate\Http\Response (JSON)
     */
    public function api_logout(Request $request){

        $logoutData = Logout::revoke_token($request);
        return response()->json($logoutData);
    }

}
