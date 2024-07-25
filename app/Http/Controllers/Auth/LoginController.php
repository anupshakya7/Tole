<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Hash;
use Session;
use App\User;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('guest')->except([
        'logout',
        'locked',
        'unlock'
		]);
       // $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request){
        $this->guard()->logout();
		$request->session()->flush();
		$request->session()->regenerate();

		return redirect()->route('login');
    }
	
	//lock screen
	public function locked()
	{
		if(!session('lock-expires-at'))
		{ 			
			return redirect()->route('admin.home');
		}
		
		if(session('lock-expires-at') < now())
		{	
			return redirect()->route('admin.home');
		}
		return view('admin.lockscreen.lockscreen');
	}
	
	public function unlock(Request $request)
	{
		//dd($request->all());
		$check = Hash::check($request->password,$request->user()->password);
		//dd($check);
		if(!$check)
		{
			return redirect()->route('locked')->with("message", "Password is incorrect!!");;
		}
		
		session(['lock-expires-at' => now()->addMinutes(\Auth::user()->getLockoutTime())]);
		
		return redirect()->route('admin.home')->with("message", "Logged in successfully!!");;
	}
    
}
