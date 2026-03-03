<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::check() || Auth::user()->role !== 'admin') {
        //      return redirect()->intended(route('home'));
        // }
        $premission = has_role_permission(Auth::user()->role,'view dashboard');
         if($premission == false){
            return redirect()->intended(route('home'));
         }

        return $next($request);
    }
}
