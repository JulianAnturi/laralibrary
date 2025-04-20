<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class JwtMiddleware
{
    //[JwtMiddleware::class]
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['message' => 'Token no proporcionado'], 401);
        }

        $token = substr($authHeader, 7); // Quita "Bearer "

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        // Autentica el usuario con el token
        $user = $accessToken->tokenable;

        Auth::setUser($user);

        return $next($request);
    }
}
