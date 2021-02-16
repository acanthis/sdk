<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LessOrEqualThanValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_cannotBeLessOrEqual';
    private const ERROR_IS_NOT_NUMERIC = 'form_validation_isNotNumeric';

    private ?int $value = null;

    public function isValid(ElementInterface $element): bool
    {
        if (null === $this->value) {
            throw new InvalidArgumentException('value cannot be empty');
        }

        if (!is_numeric($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_IS_NOT_NUMERIC, ['value' => $this->value]));

            return false;
        }

        if (!$this->validate($element->getValue())) {
            $this->setErrors(new Message(self::ERROR, ['value' => $this->value]));

            return false;
        }

        return true;
    }

    public function setValue(int $value): LessOrEqualThanValidator
    {
        $this->value = $value;

        return $this;
    }

    private function validate($value): bool
    {
        return $value >= $this->value;
    }
}
