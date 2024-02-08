<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SecretKeyService;

class VerifySecretKey
{
    public function handle(Request $request, Closure $next)
    {
        $clientKey = $request->header('X-Secret-Key');
        $serverKey = SecretKeyService::generateKey();

        if ($clientKey !== $serverKey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}