<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Block modifying requests (POST, PUT, PATCH, DELETE) when demo mode is enabled.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.demo_mode') && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This action is disabled in demo mode.',
                ], 403);
            }

            return back()->with('error', 'This action is disabled in demo mode.');
        }

        return $next($request);
    }
}
