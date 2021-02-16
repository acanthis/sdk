<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class JsonValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isNotJSON';

    public function isValid(ElementInterface $element): bool
    {
        json_decode($element->getValue());

        return (json_last_error() == JSON_ERROR_NONE);
    }
}
