<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! in_array(
            auth()->user()->role,
            ['admin', 'micronutritionist'],
            true
        )) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}