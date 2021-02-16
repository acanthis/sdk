<?php

namespace Nrg\Form\Element;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\UuidValidator;

class UuidRequiredElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('id')
            ->isRequired()
            ->addFilter(new TrimFilter())
            ->addValidator(new UuidValidator())
        ;
    }
}
