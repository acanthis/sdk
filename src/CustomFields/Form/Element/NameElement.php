<?php

namespace Eds\CustomFields\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;

class NameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('name')
            ->addFilter(new TrimFilter())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(200)
            )
        ;
    }
}
