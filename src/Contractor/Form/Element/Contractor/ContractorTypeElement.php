<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Eds\Contractor\Value\ContractorType;
use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\InArrayValidator;

class ContractorTypeElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('type')
            ->addFilter(new TrimFilter())
            ->addValidator(
                (new InArrayValidator())
                    ->setHaystack(ContractorType::CONTRACTOR_TYPE_MAP)
            )
        ;
    }
}
