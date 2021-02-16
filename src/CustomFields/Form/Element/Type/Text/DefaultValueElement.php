<?php

namespace Eds\CustomFields\Form\Element\Type\Text;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;

class DefaultValueElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('defaultValue')
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
