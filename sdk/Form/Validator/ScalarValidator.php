<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class ScalarValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isNotScalar';

    public function isValid(ElementInterface $element): bool
    {
        if (!is_scalar($element->getValue())) {
            $this->setErrors(self::ERROR);

            return false;
        }

        return true;
    }
}
