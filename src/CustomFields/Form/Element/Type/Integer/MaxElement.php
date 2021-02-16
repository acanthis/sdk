<?php

namespace Eds\CustomFields\Form\Element\Type\Integer;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\IntegerValidator;

class MaxElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('max')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new IntegerValidator())
        ;
    }
}
