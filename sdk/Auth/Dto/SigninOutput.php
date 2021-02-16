<?php

namespace Nrg\Auth\Dto;

use JsonSerializable;
use Lcobucci\JWT\Token;

class SigninOutput implements JsonSerializable
{
    private Token $accessToken;
    private Token $refreshToken;

    public function __construct(Token $accessToken, Token $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function getAccessToken(): Token
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): Token
    {
        return $this->refreshToken;
    }

    public function jsonSerialize(): array
    {
        return [
            'accessToken' => (string) $this->getAccessToken(),
            'refreshToken' => (string) $this->getRefreshToken(),
        ];
    }
}
