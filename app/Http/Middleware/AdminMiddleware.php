<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

class AdminMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        if (Auth::user()->role !== $roles) {
            abort(403, 'unauthorized');
        }

        return $next($request);
    }

}
