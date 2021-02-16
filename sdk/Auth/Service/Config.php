<?php

namespace Nrg\Auth\Service;

use Nrg\Auth\Abstraction\ConfigInterface;

class Config implements ConfigInterface
{
    private string $accessTokenTtl;
    private int $saltLength;
    private string $refreshTokenTtl;
    private string $signupConfirmationTokenTtl;

    public function __construct(
        string $accessTokenTtl,
        string $refreshTokenTtl,
        string $signupConfirmationTokenTtl,
        int $saltLength
    ) {
        $this->accessTokenTtl = $accessTokenTtl;
        $this->refreshTokenTtl = $refreshTokenTtl;
        $this->signupConfirmationTokenTtl = $signupConfirmationTokenTtl;
        $this->saltLength = $saltLength;
    }

    public function getAccessTokenTtl(): string
    {
        return $this->accessTokenTtl;
    }

    public function getSaltLength(): int
    {
        return $this->saltLength;
    }

    public function getRefreshTokenTtl(): string
    {
        return $this->refreshTokenTtl;
    }

    public function getSignupConfirmationTokenTtl(): string
    {
        return $this->signupConfirmationTokenTtl;
    }
}