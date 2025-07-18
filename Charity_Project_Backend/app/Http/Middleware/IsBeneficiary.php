<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IsBeneficiary
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Log::info('User ID: ' . Auth::id());
            Log::info('User role: ' . Auth::user()->role);
        }

        if (Auth::check() && Auth::user()->role === 'مستفيد') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized. beneficiary Only.'], 403);
    }
}
