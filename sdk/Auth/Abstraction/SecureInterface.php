<?php

namespace Nrg\Auth\Abstraction;

use Lcobucci\JWT\Token;
use Nrg\Auth\Entity\User;

interface SecureInterface
{
    public const CLAIM_USER_ID = 'userId';
    public const CLAIM_USER_STATUS = 'userStatus';
    public const CLAIM_TOKEN_TYPE = 'tokenType';

    public function generateAccessToken(User $user): Token;

    public function generateRefreshToken(User $user): Token;

    public function generateSignupConfirmationToken(User $user): Token;

    public function generateSalt(): string;

    public function parseToken(string $token): Token;

    public function verifyToken(Token $token, User $user): bool;

    public function isValidToken(Token $token, ?int $tokenType = null): bool;
}