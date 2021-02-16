<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class RequiredValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isRequired';

    public function isValid(ElementInterface $element): bool
    {
        if (!$element->hasValue() || $element->hasEmptyValue()) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }
}
