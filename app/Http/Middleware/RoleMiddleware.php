<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $userRole = auth()->user()->role;

        if ($userRole === 'super_admin') {
            return $next($request);
        }

        if ($userRole !== $role) {
            abort(403, __('messages.unauthorized_action'));
        }

        return $next($request);
    }
}
