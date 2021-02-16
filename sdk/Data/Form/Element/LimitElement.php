<?php

namespace Nrg\Data\Form\Element;

use Nrg\Data\Dto\Pagination;
use Nrg\Form\Element;
use Nrg\Form\Validator\IntegerValidator;
use Nrg\Form\Validator\RangeValidator;

class LimitElement extends Element
{
    private RangeValidator $rangeValidator;

    public function __construct()
    {
        $this->rangeValidator = (new RangeValidator())
            ->setMinValue(Pagination::MIN_LIMIT)
            ->setMaxValue(Pagination::MAX_LIMIT)
        ;

        $this
            ->setName('limit')
            ->addValidator((new IntegerValidator()))
            ->addValidator($this->rangeValidator)
        ;
    }

    public function setMinValue(int $value): LimitElement
    {
        $this->rangeValidator->setMinValue($value);

        return $this;
    }

    public function setMaxValue(int $value): LimitElement
    {
        $this->rangeValidator->setMaxValue($value);

        return $this;
    }
}
