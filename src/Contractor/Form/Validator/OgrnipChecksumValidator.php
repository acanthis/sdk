<?php

namespace Eds\Contractor\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class OgrnipChecksumValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_incorrectOgrnip';

    public function isValid(ElementInterface $element): bool
    {
        if (!$this->checksumValidate($element->getValue())) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }

    private function checksumValidate(string $ogrnIp): bool
    {
        $n15 = (int) substr(
            bcsub(
                substr($ogrnIp, 0, -1),
                bcmul(bcdiv(substr($ogrnIp, 0, -1), '13', 0), '13')
            ),
            -1
        );

        return $n15 === (int) $ogrnIp[14];
    }
}
