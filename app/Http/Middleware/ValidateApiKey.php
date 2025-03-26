<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the API key from the request headers
        $apiKey = $request->header('Authorization');
        // Check if the API key matches the one in the .env file
        if ($apiKey !== config('app.api_key')) {
            return response()->json(['error' => 'Unauthorized. Invalid API key.'], 401);
        }

        return $next($request);
    }
}
