<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LengthStringRangeValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR_LENGTH_RANGE = 'form_validation_lengthMustBeInRange';
    public const ERROR_LENGTH_GREAT = 'form_validation_lengthCannotBeGreat';
    public const ERROR_LENGTH_LESS = 'form_validation_lengthCannotBeLess';

    private ?int $minLength = null;
    private ?int $maxLength = null;
    private bool $inclusive = true;

    public function isValid(ElementInterface $element): bool
    {
        if (null !== $this->minLength && null !== $this->maxLength) {
            if ($this->minLength > $this->maxLength) {
                throw new InvalidArgumentException('maxLength cannot be less than minLength');
            }

            if ($this->minLength === $this->maxLength) {
                throw new InvalidArgumentException('minLength and maxLength cannot be equal. Use LengthEqualValidator');
            }
        }

        $length = $this->extractLength($element->getValue());

        if (null !== $this->minLength && null === $this->maxLength && !$this->validateMinLength($length)) {
            $this->setErrors(new Message(self::ERROR_LENGTH_LESS, ['minLength' => $this->minLength]));

            return false;
        }

        if (null !== $this->maxLength && null === $this->minLength && !$this->validateMaxLength($length)) {
            $this->setErrors(new Message(self::ERROR_LENGTH_GREAT, ['maxLength' => $this->maxLength]));

            return false;
        }

        if (null !== $this->minLength && null !== $this->maxLength && !($this->validateMinLength($length) && $this->validateMaxLength($length))) {
            $this->setErrors(new Message(self::ERROR_LENGTH_RANGE, ['minLength' => $this->minLength, 'maxLength' => $this->maxLength]));

            return false;
        }

        return true;
    }

    public function setMinLength(int $value): LengthStringRangeValidator
    {
        $this->minLength = $value;

        return $this;
    }

    public function setMaxLength(int $value): LengthStringRangeValidator
    {
        $this->maxLength = $value;

        return $this;
    }

    public function setInclusive(bool $inclusive): LengthStringRangeValidator
    {
        $this->inclusive = $inclusive;

        return $this;
    }

    private function extractLength($value): ?int
    {
        if (is_string($value)) {
            return mb_strlen($value, mb_detect_encoding($value, mb_detect_order(), true));
        }

        if (is_int($value)) {
            return strlen((string) $value);
        }

        return null;
    }

    private function validateMinLength(int $length): bool
    {
        if (null === $this->minLength) {
            return true;
        }

        if ($this->inclusive) {
            return $length >= $this->minLength;
        }

        return $length > $this->minLength;
    }

    private function validateMaxLength(int $length): bool
    {
        if (null === $this->maxLength) {
            return true;
        }

        if ($this->inclusive) {
            return $length <= $this->maxLength;
        }

        return $length < $this->maxLength;
    }
}
