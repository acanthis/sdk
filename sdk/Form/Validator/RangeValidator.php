<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class RangeValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR_RANGE = 'form_validation_mustBeRange';
    public const ERROR_GREAT = 'form_validation_cannotBeGreat';
    public const ERROR_LESS = 'form_validation_cannotBeLess';

    private $minValue;
    private $maxValue;
    private bool $inclusive = true;

    public function isValid(ElementInterface $element): bool
    {
        if (null !== $this->minValue && null !== $this->maxValue) {
            if (gettype($this->minValue) !== gettype($this->maxValue)) {
                throw new InvalidArgumentException('minValue and maxValue cannot be different type');
            }

            if ($this->minValue > $this->maxValue) {
                throw new InvalidArgumentException('maxValue cannot be less than minValue');
            }
        }

        if (null !== $this->minValue && null === $this->maxValue && !$this->validateMinValue($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_LESS, ['minValue' => $this->minValue]));

            return false;
        }

        if (null !== $this->maxValue && null === $this->minValue && !$this->validateMaxValue($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_GREAT, ['maxValue' => $this->maxValue]));

            return false;
        }

        if (null !== $this->minValue && null !== $this->maxValue && !$this->validateInterval($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_RANGE, ['minValue' => $this->minValue, 'maxValue' => $this->maxValue]));

            return false;
        }

        return true;
    }

    public function setMinValue($value): RangeValidator
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('minValue must be numeric type');
        }

        $this->minValue = $value;

        return $this;
    }

    public function setMaxValue($value): RangeValidator
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('maxValue must be numeric type');
        }

        $this->maxValue = $value;

        return $this;
    }

    public function setInclusive(bool $inclusive): RangeValidator
    {
        $this->inclusive = $inclusive;

        return $this;
    }

    private function validateMinValue($value): bool
    {
        if (null === $this->minValue) {
            return true;
        }

        if ($this->inclusive) {
            return $value >= $this->minValue;
        }

        return $value > $this->minValue;
    }

    private function validateMaxValue($value): bool
    {
        if (null === $this->maxValue) {
            return true;
        }

        if ($this->inclusive) {
            return $value <= $this->maxValue;
        }

        return $value < $this->maxValue;
    }

    private function validateInterval($value): bool
    {
        if ($this->inclusive) {
            return ($value >= $this->minValue) && ($value <= $this->maxValue);
        }

        return ($value > $this->minValue) && ($value < $this->maxValue);
    }
}
