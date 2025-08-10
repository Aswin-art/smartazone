<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // $subdomain = explode('.', $request->getHost())[0];
        // $tenant = Tenant::where('subdomain', $subdomain)->first();

        // if (!$tenant) {
        //     abort(404, 'Tenant tidak ditemukan');
        // }

        // app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}
