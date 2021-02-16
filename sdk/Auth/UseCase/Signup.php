<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Dto\SigninOutput;
use Nrg\Auth\Dto\SignupInput;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Auth\Persistence\PgSql\Factory\UserFactory;
use Nrg\Auth\Value\UserStatus;
use Nrg\Utility\Abstraction\UuidGenerator;

class Signup
{
    private UserRepository $userRepository;
    private UuidGenerator $uuid;
    private UserFactory $userFactory;
    private SecureInterface $secure;

    public function __construct(
        UserRepository $userRepository,
        UserFactory $userFactory,
        UuidGenerator $uuid,
        SecureInterface $secure
    ) {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->uuid = $uuid;
        $this->secure = $secure;
    }

    public function execute(SignupInput $input): SigninOutput
    {
        $user = $this->userFactory->createEntity(
            [
                'id' => $this->uuid->generateV4(),
                'email' => $input->getEmail(),
                'password' => password_hash($input->getPassword(), PASSWORD_DEFAULT),
                'status' => UserStatus::PENDING_SIGNUP_CONFIRMATION,
                'salt' => $this->secure->generateSalt(),
            ]
        );

        $this->userRepository->create($user);

        $token = (string)$this->secure->generateSignupConfirmationToken($user);
        //todo: send email here

        return new SigninOutput(
            $this->secure->generateAccessToken($user),
            $this->secure->generateRefreshToken($user)
        );
    }
}
