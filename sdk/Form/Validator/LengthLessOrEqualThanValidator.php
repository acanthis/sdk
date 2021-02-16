<?php

namespace Nrg\Form\Validator;

use Countable;
use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LengthLessOrEqualThanValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_lengthMustBeLessOrEqual';

    private ?int $length = null;

    public function isValid(ElementInterface $element): bool
    {
        if (null === $this->length) {
            throw new InvalidArgumentException('length cannot be empty');
        }

        if ($this->extractLength($element->getValue()) > $this->length) {
            $this->setErrors(new Message(self::ERROR, ['length' => $this->length]));

            return false;
        }

        return true;
    }

    public function setLength(int $length): LengthLessOrEqualThanValidator
    {
        $this->length = $length;

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

        if (is_array($value) || $value instanceof Countable) {
            return count($value);
        }

        if (is_object($value)) {
            return count(get_object_vars($value));
        }

        return null;
    }
}
