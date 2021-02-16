<?php

namespace Nrg\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class InArrayValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'form_validation_inArray.incorrectValue';

    private array $haystack = [];
    private bool $strict = false;

    public function isValid(ElementInterface $element): bool
    {
        if (!in_array($element->getValue(), $this->haystack, $this->strict)) {
            $this->setErrors(new Message(self::ERROR, $this->haystack));

            return false;
        }

        return true;
    }

    public function setHaystack(array $haystack): self
    {
        $this->haystack = $haystack;

        return $this;
    }

    public function setStrict(bool $strict): self
    {
        $this->strict = $strict;

        return $this;
    }
}
