<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;

class UuidValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_isNotUuid';
    public const PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    public function isValid(ElementInterface $element): bool
    {
        if (!self::isUuid($element->getValue())) {
            $this->setErrors(self::ERROR);

            return false;
        }

        return true;
    }

    public static function isUuid(string $value): bool
    {
        return 1 === preg_match(self::PATTERN, $value);
    }
}
