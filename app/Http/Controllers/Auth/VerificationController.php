<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
