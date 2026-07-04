<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'You do not have admin access.');
        }

        if (! auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}
