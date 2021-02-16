<?php

namespace Nrg\Form\Validator;

use Countable;
use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LengthEqualValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'form_validation_incorrectLength';

    private array $lengths = [];

    public function isValid(ElementInterface $element): bool
    {
        if (!$this->lengths) {
            throw new InvalidArgumentException('length not be empty');
        }

        $length = $this->extractLength($element->getValue());

        if (!in_array($length, $this->lengths)) {
            $this->setErrors(new Message(self::ERROR, ['lengths' => $this->lengths]));

            return false;
        }

        return true;
    }

    public function addLength(int $length): LengthEqualValidator
    {
        $this->lengths[] = $length;

        return $this;
    }

    public function setLengths(array $lengths): LengthEqualValidator
    {
        $this->lengths = $lengths;

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
