<?php

namespace Nrg\Form\Validator;

use InvalidArgumentException;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

// todo: rethinking all solution
class DateTimeValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const DATE_FORMAT = 'd';
    public const DATE_TIME_FORMAT = 'dt';
    public const ISO8601_FORMAT = 'c';
    public const RFC2822_FORMAT = 'r';

    public const EXCEPTIONAL_FORMATS = [
        self::DATE_FORMAT => 'Y-m-d',
        self::DATE_TIME_FORMAT => 'Y-m-d H:i',
        self::ISO8601_FORMAT => 'Y-m-d\TH:i:sP',
        self::RFC2822_FORMAT => 'D, d M Y H:i:s O',
    ];

    private const ERROR = 'form_validation_incorrectFormatDate';

    private string $format = 'd.m.Y';

    public function isValid(ElementInterface $element): bool
    {
        if (!is_string($element->getValue())) {
            throw new InvalidArgumentException('value must be string');
        }

        if (in_array($this->format, array_keys(self::EXCEPTIONAL_FORMATS))) {
            $this->format = self::EXCEPTIONAL_FORMATS[$this->format];
        }

        $dateInfo = date_parse_from_format($this->format, $element->getValue());

        if (0 !== $dateInfo['error_count'] || 0 !== $dateInfo['warning_count']) {
            $this->setErrors(new Message(self::ERROR, ['format' => $this->format]));

            return false;
        }

        return true;
    }

    public function setFormat(string $format): DateTimeValidator
    {
        $this->format = $format;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
