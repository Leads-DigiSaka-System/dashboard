<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictSalesMan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and has role = 5
        if (Auth::check() && Auth::user()->role == 5) {
            return redirect()->route('dashboard.index')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}

