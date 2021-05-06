<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    /*
     * EDIT 2020-08-08
     */
    //protected $redirectTo = '/home';
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
     * EDIT 2020-08-08
     */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     };
    
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }
    
    // Guard
    protected function guard()
    {
        return Auth::guard('user');
    }
    
    // 
    public function showLoginForm()
    {
        return view('user.auth.login');
    }
    
    // 
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        
        return $this->loggedOut($request);
    }
    
    // 
    public function loggedOut(Request $request)
    {
        return redirect(route('user.login'));
    }
}
