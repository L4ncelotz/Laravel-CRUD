<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckResourceOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $resource = $request->route()->parameters();
        
        // ถ้ามี resource และ user_id ไม่ตรงกับ user ที่ login
        if (!empty($resource) && $resource[key($resource)]->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'You are not authorized to access this resource'
            ], 403);
        }

        return $next($request);
    }
} 