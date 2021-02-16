<?php

namespace Nrg\Auth\Form\Validator;

use Nrg\Auth\Dto\SigninInput;
use Nrg\Auth\UseCase\IsValidCredentials;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class CredentialValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'auth_validation_invalidCredential';

    private IsValidCredentials $isValidCredentials;

    public function __construct(IsValidCredentials $isValidCredentials)
    {
        $this->isValidCredentials = $isValidCredentials;
    }

    public function isValid(ElementInterface $element): bool
    {
        /**
         * @var $email ElementInterface
         */
        $email = $element->getParent()->getElement('email');
        if (!$email->isValid()) { // todo: cache for isValid result
            return true;
        }

        $isValidCredentials = $this->isValidCredentials->execute(
            new SigninInput(
                [
                    'email' => $email->getValue(),
                    'password' => $element->getValue(),
                ]
            )
        );

        if (!$isValidCredentials) {
            $this->setErrors(self::ERROR);

            return false;
        }

        return true;
    }
}
