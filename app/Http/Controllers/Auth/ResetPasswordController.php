<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;
    protected function redirectTo()
    {

        $user = Auth::user();

        if ($user->role == '0' && $user->ban == '0') {
            $this->redirectTo = '/_ds/dashboard';
            return $this->redirectTo;
        }

        if ($user->role == '1' && $user->ban == '0') {

            $this->redirectTo = '/_dt/dashboard';
            return $this->redirectTo;
        }

        if ($user->role == '2' && $user->ban == '0') {
            session()->flash('success', 'Login Successful');
            $this->redirectTo = '/_dmgt/dashboard';
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
        $this->middleware('guest');
    }
}
