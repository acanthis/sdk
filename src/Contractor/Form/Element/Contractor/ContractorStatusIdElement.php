<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\UuidValidator;

class ContractorStatusIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('statusId')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new UuidValidator())
        ;
    }
}
