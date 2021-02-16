<?php

namespace Nrg\Data\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;

class ConditionValueElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('value')
            ->addFilter(new TrimFilter())
            ->isRequired()
        ;
    }
}
