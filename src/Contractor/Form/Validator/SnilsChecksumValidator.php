<?php

namespace Eds\Contractor\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class SnilsChecksumValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_incorrectSnils';

    public function isValid(ElementInterface $element): bool
    {
        if (!$this->checksumValidate($element->getValue())) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }

    private function checksumValidate(string $snils): bool
    {
        $sum = 0;
        $checkDigit = 0;

        for ($i = 0; $i < 9; ++$i) {
            $sum += (int) $snils[$i] * (9 - $i);
        }

        if ($sum < 100) {
            $checkDigit = $sum;
        } elseif ($sum > 101) {
            $checkDigit = $sum % 101;

            if (100 === $checkDigit) {
                $checkDigit = 0;
            }
        }

        return $checkDigit === (int) substr($snils, -2);
    }
}
