<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoreAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->canAccessStore()) {
            return redirect()->route('store.gate')
                ->with('error', 'Employee access required. Please log in with your employee account.');
        }

        return $next($request);
    }
}
