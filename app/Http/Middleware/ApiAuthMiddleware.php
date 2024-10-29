<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ApiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiToken = $request->header('Authorization');
        if (!$apiToken || !User::where('api_token', $apiToken)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
