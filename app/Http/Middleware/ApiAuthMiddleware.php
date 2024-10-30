<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->header('X-API-KEY') !== config('services.api_key')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
