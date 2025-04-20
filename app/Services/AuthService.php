<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\User;

class AuthService
{

    static function tokenIsValid($token)
    { {
            return 'entre a token is valid';
            $tokenObject = User::firstWhere('token', hash('sha256', $token))->first();

            if (!$tokenObject) {
                return false;
            }

            $expiresAt = $tokenObject->created_at->addMinutes($tokenObject->abilities['expires_in']);
            if ($expiresAt < now()) {
                return false;
            }

            return true;
        }
    }

    static function response($token, $user, $cookie)
    {
        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'user' => $user,

        ])->withCookie($cookie);
    }
}
