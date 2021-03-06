<?php

namespace Eds\CustomFields\Form\Element\Type\Numeric;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\NumericValidator;

class MinElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('min')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new NumericValidator())
        ;
    }
}
