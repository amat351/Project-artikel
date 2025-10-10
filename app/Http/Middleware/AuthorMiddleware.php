<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorMiddleware
{
   public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        if (Auth::user()->role !== $role) {
            abort(403, 'unauthorized');
        }

        return $next($request);
    }
}
