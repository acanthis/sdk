<?php

namespace Eds\Contractor\Form\Element\Contact;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class ContactNameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('name')
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(255)
            )
        ;
    }
}
