<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return response()->json(['message' => 'Unauthorized: Admin access only.'], 401);
        }
        if (!$admin->is_super_admin) {
            return response()->json(['message' => 'Unauthorized: Super Admin access only.'], 403);
        }
        return $next($request);
    }
}
