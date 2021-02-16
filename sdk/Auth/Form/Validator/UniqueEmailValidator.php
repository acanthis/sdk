<?php

namespace Nrg\Auth\Form\Validator;

use Nrg\Auth\UseCase\IsUniqueEmail;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class UniqueEmailValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'auth_validation_emailAlreadyExists';

    private IsUniqueEmail $isUniqueEmail;

    public function __construct(IsUniqueEmail $isUniqueEmail)
    {
        $this->isUniqueEmail = $isUniqueEmail;
    }

    public function isValid(ElementInterface $element): bool
    {
        $isValid = $this->isUniqueEmail->execute($element->getValue());

        if (!$isValid) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }
}
