<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
    
        if (!$user) {
            abort(401);
        }
    
        // 🔥 USER ROLES NAME LARINI OLAMIZ
        $userRoles = $user->roles->pluck('name')->toArray();
    
        // 🔥 CHECK
        if (!array_intersect($roles, $userRoles)) {
            abort(403, 'Sizda ruxsat yo‘q');
        }
    
        return $next($request);
    }
}
