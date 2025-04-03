<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        
        // Добавим логгирование для отладки
        \Log::info('Requested with token: ' . $token);
        \Log::info('Expected token: ' . config('services.api.token'));
        
        if ($token !== config('services.api.token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return $next($request);
    }
} 