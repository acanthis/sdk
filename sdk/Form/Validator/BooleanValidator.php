<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class BooleanValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isNotBoolean';

    public function isValid(ElementInterface $element): bool
    {
        if (!is_bool($element->getValue())) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }
}
