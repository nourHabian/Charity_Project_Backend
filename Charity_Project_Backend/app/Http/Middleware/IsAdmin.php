<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json(['message' => 'Unauthorized: Admin access only.'], 401);
        }
        if ($admin->deleted) {
            return response()->json(['message' => 'Unauthorized: This account is deleted by super admin.'], 401);
        }
        return $next($request);
    }
}
