<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogViewerAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        //@dd(auth()->user()->role);
        if (!auth()->check()) {
            abort(403);
        }

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}