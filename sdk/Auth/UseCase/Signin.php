<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Abstraction\SecureInterface;
use Nrg\Auth\Dto\SigninInput;
use Nrg\Auth\Dto\SigninOutput;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class Signin
{
    private UserRepository $userRepository;
    private SecureInterface $secure;

    public function __construct(UserRepository $userRepository, SecureInterface $secure)
    {
        $this->userRepository = $userRepository;
        $this->secure = $secure;
    }

    public function execute(SigninInput $input): SigninOutput
    {
        $user = $this->userRepository->findOne(
            (new Filter())
                ->addCondition(
                    (new EqualCondition())
                        ->setField('email')
                        ->setValue($input->getEmail())
                )
        );

        return new SigninOutput(
            $this->secure->generateAccessToken($user),
            $this->secure->generateRefreshToken($user)
        );

    }
}
