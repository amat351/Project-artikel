<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminOrSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // pastikan yang dicek adalah kolom "role" atau "roles" sesuai database kamu
        $userRole = strtolower(Auth::user()->role ?? Auth::user()->roles ?? '');

        if (!in_array($userRole, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
