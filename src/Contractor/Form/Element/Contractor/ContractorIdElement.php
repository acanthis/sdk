<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\UuidValidator;

class ContractorIdElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('contractorId')
            ->addFilter(new TrimFilter())
            ->addValidator((new UuidValidator()))
        ;
    }
}
