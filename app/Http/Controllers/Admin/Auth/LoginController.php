<?php

namespace App\Http\Controllers\Admin\Auth;

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
    /*
     * ADD 2020-08-22
     * 
     */
    //protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
    protected function redirectTo() {
    	if(! Auth::user()) {
    		return '/';
    	}
    	return route('admin.home', ['admin' => Auth::id()]);
    }
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
    //     }protected $redirectTo = RouteServiceProvider::HOME;
		
	public function __construct()
	{
        $this->middleware('guest:admin')->except('logout');
	}

	// 
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    // 
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    
    //
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        return $this->loggedOut($request);
    }
    
    // 
    public function loggedOut(Request $request)
    {
        return redirect(route('admin.login'));
    }
}
