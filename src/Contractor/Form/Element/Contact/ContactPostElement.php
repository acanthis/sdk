<?php

namespace Eds\Contractor\Form\Element\Contact;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class ContactPostElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('post')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(150)
            )
        ;
    }
}
