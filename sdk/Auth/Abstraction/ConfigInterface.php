<?php

namespace Nrg\Auth\Abstraction;

interface ConfigInterface
{
    public function getAccessTokenTtl(): string;

    public function getRefreshTokenTtl(): string;

    public function getSignupConfirmationTokenTtl(): string;

    public function getSaltLength(): int;
}