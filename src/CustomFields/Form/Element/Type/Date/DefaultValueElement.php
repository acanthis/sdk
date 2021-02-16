<?php

namespace Eds\CustomFields\Form\Element\Type\Date;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\DateTimeValidator;

class DefaultValueElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('defaultValue')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator((new DateTimeValidator())
                ->setFormat(DateTimeValidator::DATE_TIME_FORMAT)
            )
        ;
    }
}