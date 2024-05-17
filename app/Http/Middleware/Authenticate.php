<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Log; // Correct import

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        Log::info('Unauthenticated request.', [
            'token' => $request->bearerToken(),
            'guards' => $guards
        ]);
        
        abort(response()->json(['message' => 'Unauthenticated.'], 401));
    }

    public function handle($request, Closure $next, ...$guards)
    {
        Log::info('Processing request in Authenticate middleware.', [
            'token' => $request->bearerToken(),
            'user' => auth()->user(),
            'request_data' => $request->all()
        ]);
    
        $this->authenticate($request, $guards);
    
        return $next($request);
    }
}
