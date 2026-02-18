<?php

namespace App\Utils;

class PasswordUtil
{
    private const COST = 12;

    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => self::COST]);
    }

    
    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
