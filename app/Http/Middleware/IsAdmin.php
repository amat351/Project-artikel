<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        // Pastikan user login & is_admin = 1
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return $next($request);
        }
        if (auth()->check() && auth()->user()->is_admin == 0) {
            // Redirect ke halaman posts jika user bukan admin
            return redirect('/posts')->with('error', 'You do not have admin access.');
        }

        // Kalau bukan admin lempar error
        abort(403, 'Unauthorized action.');
    }
}
