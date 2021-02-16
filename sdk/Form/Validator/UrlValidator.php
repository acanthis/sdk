<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class UrlValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isNotUrl';

    public function isValid(ElementInterface $element): bool
    {
        if (false === filter_var($element->getValue(), FILTER_VALIDATE_URL)) {
            $this->setErrors(self::ERROR);

            return false;
        }

        return true;
    }
}
