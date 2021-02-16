<?php

namespace Nrg\Form\Validator;

use DateTime;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class LessThanDateTimeValidator extends DateTimeValidator
{
    use ErrorsTrait;

    private const ERROR = 'form_validation_mustBeLessThanDateTime';
    private DateTime $dateTime;

    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function isValid(ElementInterface $element): bool
    {
        if (false === parent::isValid($element)) {
            return false;
        }

        $dateTimeValue = DateTime::createFromFormat($this->getFormat(), $element->getValue());

        if ($dateTimeValue > $this->dateTime) {
            $this->setErrors(new Message(self::ERROR, ['lessThanDateTime' => $this->dateTime]));

            return false;
        }

        return true;
    }
}
