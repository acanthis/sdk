<?php

namespace Eds\CustomFields\Form\Element\Type\Boolean;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\BooleanValidator;

class DefaultValueElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('defaultValue')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new BooleanValidator())
        ;
    }
}
