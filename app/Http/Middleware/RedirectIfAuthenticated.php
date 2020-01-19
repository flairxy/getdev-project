<?php

namespace App\Http\Middleware;

use App\Models\Tutor;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            if ($user->role == '0' && $user->ban == '0') {
                return redirect('/_student/dashboard');
            } else

            if ($user->role == '1' && $user->ban == '0') {
                return redirect('/_staff/dashboard');
            } else

            if ($user->role == '2' && $user->ban == '0') {
                return redirect('/_management/dashboard');;
            }
        }

        return $next($request);
    }
}
