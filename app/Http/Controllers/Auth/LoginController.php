<?php

namespace App\Http\Controllers\Auth;

use App\detail;
use Illuminate\Support\Facades\Auth;
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
    
    //protected $redirectTo = '/';
    protected function redirectTo(){ //When user press "Home" button, this method checks if user already filled mandatory profile details
        $user_id = Auth::user()->id;
        $verification = Auth::user()->email_verified_at;
        $user_detail = detail::where('user_id', $user_id)->get();   //Retrieve the user details
        $userdetailarray = $user_detail->toArray();
        if (empty($userdetailarray)) { //If user didn't fill details yet
            if ($verification == "") {
                return '/email/verify';
            }else{
                return '/welcome';
            }
        }else {
            return '/home';                               //If user already filled details
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
