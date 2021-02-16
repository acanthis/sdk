<?php

namespace Nrg\Auth\Value;

use InvalidArgumentException;

class TokenType
{
    public const ACCESS = 1;
    public const REFRESH = 2;
    public const SIGNUP_CONFIRMATION = 3;

    private const ALLOWED_VALUES = [
        self::ACCESS,
        self::REFRESH,
        self::SIGNUP_CONFIRMATION,
    ];

    private int $value;

    public function __construct(int $value)
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new InvalidArgumentException('Invalid token was provided');
        }

        $this->value = $value;
    }

    public static function createAccess(): TokenType
    {
        return new self(self::ACCESS);
    }

    public static function createRefresh(): TokenType
    {
        return new self(self::REFRESH);
    }

    public static function createSignupConfirmation(): TokenType
    {
        return new self(self::SIGNUP_CONFIRMATION);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqual($token): bool
    {
        if ($token instanceof self) {
            return $this->getValue() === $token->getValue();
        }

        return $this->getValue() === (int)$token;
    }
}
