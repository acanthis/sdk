<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;

class DescriptionElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('description')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(5000)
            )
        ;
    }
}
