<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LessThanValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_cannotBeLess';

    private ?int $minValue = null;

    public function isValid(ElementInterface $element): bool
    {
        if (null === $this->minValue) {
            throw new InvalidArgumentException('minValue cannot be empty');
        }

        if (!$this->validateMin($element->getValue())) {
            $this->setErrors(new Message(self::ERROR, ['minValue' => $this->minValue]));

            return false;
        }

        return true;
    }

    public function setMinValue(int $minValue): LessThanValidator
    {
        $this->minValue = $minValue;

        return $this;
    }

    private function validateMin(int $value): bool
    {
        return $value > $this->minValue;
    }
}
