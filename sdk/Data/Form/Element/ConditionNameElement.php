<?php

namespace Nrg\Data\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\StringValidator;

class ConditionNameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('name')
            ->isRequired()
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
        ;
    }
}
