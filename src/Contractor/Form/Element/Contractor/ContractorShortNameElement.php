<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class ContractorShortNameElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('shortName')
            ->addFilter(new TrimFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(2)
                    ->setMaxLength(255)
            )
        ;
    }
}
