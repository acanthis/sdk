<?php

namespace Eds\Contractor\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class InnChecksumValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_incorrectInn';

    public function isValid(ElementInterface $element): bool
    {
        if (!is_string($element->getValue()) || !$this->checksumValidate($element->getValue())) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }

    private function checkDigit(string $inn, array $coefficients): int
    {
        $n = 0;

        foreach ($coefficients as $i => $k) {
            $n += $k * (int) $inn[$i];
        }

        return $n % 11 % 10;
    }

    private function checksumValidate(string $inn): bool
    {
        $result = false;

        switch (strlen($inn)) {
            case 10:
                $n10 = $this->checkDigit($inn, [2, 4, 10, 3, 5, 9, 4, 6, 8]);

                if ($n10 === (int) $inn[9]) {
                    $result = true;
                }

                break;
            case 12:
                $n11 = $this->checkDigit($inn, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                $n12 = $this->checkDigit($inn, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);

                if (($n11 === (int) $inn[10]) && ($n12 === (int) $inn[11])) {
                    $result = true;
                }

                break;
        }

        return $result;
    }
}
