<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Dto\SigninOutput;
use Nrg\Auth\Persistence\Abstraction\UserRepository;

class RefreshSignin
{
    private UserRepository $userRepository;
    private GetUserById $getUserById;
    private SecureInterface $secure;

    public function __construct(
        UserRepository $userRepository,
        GetUserById $getUserById,
        SecureInterface $secure
    ) {
        $this->userRepository = $userRepository;
        $this->getUserById = $getUserById;
        $this->secure = $secure;
    }

    public function execute(string $jwt): SigninOutput
    {
        $token = $this->secure->parseToken($jwt);
        $user = $this->getUserById->execute($token->getClaim(SecureInterface::CLAIM_USER_ID));

        return new SigninOutput(
            $this->secure->generateAccessToken($user),
            $this->secure->generateRefreshToken($user)
        );
    }
}
