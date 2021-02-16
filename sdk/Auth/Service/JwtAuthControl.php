<?php

namespace Nrg\Auth\Service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Nrg\Auth\Abstraction\AuthControl;
use Nrg\Auth\Entity\User;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Utility\Abstraction\Config;

class JwtAuthControl implements AuthControl
{
    private string $ttl;

    /** @var string */
    private $signature;

    private Sha256 $signer;

    private Token $accessToken;

    private User $user;

    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
        Config $config,
        string $signature = null
    ) {
        $this->userRepository = $userRepository;
        $this->signature = $signature ?? $config->get('signature');
        $this->signer = new Sha256();
    }

    public function generateAccessToken(User $user): Token
    {
        return (new Builder())
            ->setIssuedAt(time())
            ->set('user', $user->jsonSerialize())
            ->sign($this->signer, $this->signature)
            ->getToken()
        ;
    }

    public function generateRefreshToken(User $user): Token
    {
        return $this->generateAccessToken($user);
    }

    public function verifyAccessToken(string $token): bool
    {
        $accessToken = (new Parser())->parse($token);

        return $accessToken->verify($this->signer, $this->signature) &&
            $accessToken->validate(new ValidationData());
    }

    public function verifyRefreshToken(string $token): bool
    {
        return $this->verifyAccessToken($token);
    }

    public function setToken(string $token): void
    {
        $this->accessToken = (new Parser())->parse($token);
        $this->user = $this->userRepository->findOne(
            (new Filter())
                ->addCondition(
                    (new EqualCondition())
                        ->setField('email')
                        ->setValue($this->accessToken->getClaim('user')->email)
                )
        );
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
