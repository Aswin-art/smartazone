<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) { 
            return redirect('/login');
        }

        $user = Auth::user();

        if (in_array($user->user_type, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
