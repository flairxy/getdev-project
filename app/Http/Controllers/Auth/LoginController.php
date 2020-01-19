<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo;


    protected function redirectTo()
    {

        $user = Auth::user();

        if ($user->role == '0' && $user->ban == '0') {
            $this->redirectTo = '/_student/dashboard';
            return $this->redirectTo;
        }

        if ($user->role == '1' && $user->ban == '0') {

            $this->redirectTo = '/_staff/dashboard';
            return $this->redirectTo;
        }

        if ($user->role == '2' && $user->ban == '0') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/_management/dashboard';
            return $this->redirectTo;
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
