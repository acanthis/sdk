<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class RegexValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR_INCORRECT_VALUE = 'form_validation_regex.incorrectValueByRegex';
    public const ERROR_VALUE_NOT_SCALAR = 'form_validation_regex.valueMustBeScalar';

    public ?string $regex = null;

    public function isValid(ElementInterface $element): bool
    {
        if (null === $this->regex) {
            throw new InvalidArgumentException('regex cannot be empty');
        }

        if (!is_scalar($element->getValue())) {
            $this->setErrors(new Message(self::ERROR_VALUE_NOT_SCALAR, ['value' => $element->getValue()]));
        }

        if (!(bool) preg_match($this->regex, $element->getValue())) {
            $this->setErrors(new Message(self::ERROR_INCORRECT_VALUE, ['value' => $element->getValue(), 'regex' => $this->regex]));

            return false;
        }

        return true;
    }

    public function setRegex(string $regex): RegexValidator
    {
        $this->regex = $regex;

        return $this;
    }
}
