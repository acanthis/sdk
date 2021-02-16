<?php

namespace Nrg\Auth\Value;

use InvalidArgumentException;

class UserStatus
{
    public const ACTIVE = 1;
    public const PENDING_SIGNUP_CONFIRMATION = 2;

    public const ALLOWED_VALUES = [
        self::ACTIVE,
        self::PENDING_SIGNUP_CONFIRMATION,
    ];

    private int $value;

    public function __construct(int $value)
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new InvalidArgumentException('Invalid user status was provided');
        }

        $this->value = $value;
    }

    public static function createActive(): UserStatus
    {
        return new self(self::ACTIVE);
    }

    public static function createPendingSignupConfirmation(): UserStatus
    {
        return new self(self::PENDING_SIGNUP_CONFIRMATION);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqual($status): bool
    {
        if ($status instanceof self) {
            return $this->getValue() === $status->getValue();
        }

        return $this->getValue() === (int)$status;
    }
}
