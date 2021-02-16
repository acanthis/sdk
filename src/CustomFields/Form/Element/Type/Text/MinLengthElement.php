<?php

namespace Eds\CustomFields\Form\Element\Type\Text;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;

class MinLengthElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('minLength')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(255)
            )
        ;
    }
}
