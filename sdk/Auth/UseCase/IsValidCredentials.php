<?php

namespace Nrg\Auth\UseCase;

use Nrg\Auth\Dto\SigninInput;
use Nrg\Auth\Persistence\Abstraction\UserRepository;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class IsValidCredentials
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(SigninInput $input): bool
    {
        try {
            $user = $this->userRepository->findOne(
                (new Filter())
                    ->addCondition(
                        (new EqualCondition())
                            ->setField('email')
                            ->setValue($input->getEmail())
                    )
            );
        } catch (EntityNotFoundException $e) {
            return false;
        }

        return password_verify($input->getPassword(), $user->getPassword());
    }
}
