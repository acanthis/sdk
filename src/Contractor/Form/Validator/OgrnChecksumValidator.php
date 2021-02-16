<?php

namespace Eds\Contractor\Form\Validator;

use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class OgrnChecksumValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_incorrectOgrn';

    public function isValid(ElementInterface $element): bool
    {
        if (!$this->checksumValidate($element->getValue())) {
            $this->setErrors(new Message(self::ERROR));

            return false;
        }

        return true;
    }

    private function checksumValidate(string $ogrn): bool
    {
        $n13 = (int) substr(
            bcsub(
                substr($ogrn, 0, -1),
                bcmul(bcdiv(substr($ogrn, 0, -1), '11', 0), '11')
            ),
            -1
        );

        return $n13 === (int) $ogrn[12];
    }
}
