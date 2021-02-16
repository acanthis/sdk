<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class GreaterThanValidator implements ValidatorInterface
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_cannotBeGreater';
    private ?int $maxValue = null;

    public function isValid(ElementInterface $element): bool
    {
        if (null === $this->maxValue) {
            throw new InvalidArgumentException('maxValue cannot be empty');
        }

        if (!$this->validateMax($element->getValue())) {
            $this->setErrors(new Message(self::ERROR, ['maxValue' => $this->maxValue]));

            return false;
        }

        return true;
    }

    public function setMaxValue(int $maxValue): GreaterThanValidator
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    private function validateMax(int $value): bool
    {
        return $value < $this->maxValue;
    }
}
