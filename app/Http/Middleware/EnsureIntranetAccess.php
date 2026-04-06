<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIntranetAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->canAccessIntranet()) {
            return redirect()->route('login')
                ->with('error', 'Authentication required to access the intranet.');
        }

        return $next($request);
    }
}
