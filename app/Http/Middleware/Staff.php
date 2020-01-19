<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Staff
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            //           $user = $request->user();
            if (Auth::user()->role == '1') {

                return $next($request);
            }
            if (Auth::user()->role == '0') {

                return redirect('/_student/dashboard');
            }
            return redirect('/_management/dashboard');
        }
        return redirect()->route('login');
    }
}
