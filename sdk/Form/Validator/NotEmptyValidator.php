<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class NotEmptyValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_cannotBeEmpty';

    public function isValid(ElementInterface $element): bool
    {
        if (empty($element->getValue())) {
            $this->setErrors(self::ERROR);

            return false;
        }

        return true;
    }
}
