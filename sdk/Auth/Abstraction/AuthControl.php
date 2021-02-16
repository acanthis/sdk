<?php

namespace Nrg\Auth\Abstraction;

use Lcobucci\JWT\Token;
use Nrg\Auth\Entity\User;

interface AuthControl
{
    public function generateAccessToken(User $user): Token;

    public function generateRefreshToken(User $user): Token;

    public function verifyAccessToken(string $token): bool;

    public function verifyRefreshToken(string $token): bool;

    public function setToken(string $token): void;

    public function getUser(): User;
}
