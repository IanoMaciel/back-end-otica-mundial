<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse {
        $user = Auth::user();
        if (!$user || !$user->is_admin) {
            return response()->json([
                'error' => 'Você não possui permissão para esta ação.'
            ], 403);
        }
        return $next($request);
    }
}
