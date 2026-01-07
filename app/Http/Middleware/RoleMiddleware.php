<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        
        abort_unless($user, 401, 'Unauthorized');
        abort_unless(in_array($user->role, $roles), 403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');

        return $next($request);
    }
}