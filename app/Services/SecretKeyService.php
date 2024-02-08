<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class SecretKeyService
{
    public static function generateKey($salt = null): string
    {
        $secret = config('app.secret'); 
        $date = now()->toDateString();

        $salt = $salt ?? '';

        return Hash::make($secret . $date . $salt);
    }
}

