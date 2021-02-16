<?php

namespace Nrg\Auth\Service;

use DateTimeImmutable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Nrg\Auth\Abstraction\ConfigInterface;
use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Entity\User;
use Nrg\Auth\Value\TokenType;
use Nrg\Form\Validator\UuidValidator;

class Secure implements SecureInterface
{
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function generateAccessToken(User $user): Token
    {
        return $this->generateToken($user, TokenType::createAccess());
    }

    public function generateRefreshToken(User $user): Token
    {
        return $this->generateToken($user, TokenType::createRefresh());
    }

    public function generateSignupConfirmationToken(User $user): Token
    {
        return $this->generateToken($user, TokenType::createSignupConfirmation());
    }

    public function parseToken(string $token): Token
    {
        return (new Parser())->parse($token);
    }

    public function verifyToken(Token $token, User $user): bool
    {
        return $user->getStatus()->isEqual($token->getClaim(self::CLAIM_USER_STATUS)) &&
            $token->verify($this->createSigner(), $this->createKey($user->getSalt()));
    }

    public function isValidToken(Token $token, ?int $tokenType = null): bool
    {
        return !$token->isExpired() &&
            $token->hasClaim(self::CLAIM_USER_ID) &&
            $token->hasClaim(self::CLAIM_USER_STATUS) &&
            $token->hasClaim(self::CLAIM_TOKEN_TYPE) &&
            UuidValidator::isUuid($token->getClaim(self::CLAIM_USER_ID)) &&
            (
                null === $tokenType ||
                $token->getClaim(self::CLAIM_TOKEN_TYPE) === $tokenType
            );
    }

    public function generateSalt(): string
    {
        return bin2hex(random_bytes($this->config->getSaltLength() / 2));
    }

    private function generateToken(User $user, TokenType $tokenType): Token
    {
        return (new Builder())
            ->issuedAt(time())
            ->expiresAt(
                (new DateTimeImmutable())->modify(
                    $this->getTtlByTokenType($tokenType)
                )->getTimestamp()
            )
            ->withClaim(self::CLAIM_USER_ID, $user->getId())
            ->withClaim(self::CLAIM_USER_STATUS, $user->getStatus()->getValue())
            ->withClaim(self::CLAIM_TOKEN_TYPE, $tokenType->getValue())
            ->getToken($this->createSigner(), $this->createKey($user->getSalt()));
    }

    private function createSigner(): Signer
    {
        return new Sha256();
    }

    private function createKey(string $salt)
    {
        return new Key($salt);
    }

    private function getTtlByTokenType(TokenType $tokenType)
    {
        switch ($tokenType->getValue()) {
            case TokenType::ACCESS:
                return $this->config->getAccessTokenTtl();
            case TokenType::REFRESH:
                return $this->config->getRefreshTokenTtl();
            case TokenType::SIGNUP_CONFIRMATION:
                return $this->config->getSignupConfirmationTokenTtl();
            default:
                return '+1 day';
        }
    }
}