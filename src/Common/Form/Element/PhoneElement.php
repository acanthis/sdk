<?php

namespace Eds\Common\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class PhoneElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('phone')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(2)
                    ->setMaxLength(15)
            )
        ;
    }
}
