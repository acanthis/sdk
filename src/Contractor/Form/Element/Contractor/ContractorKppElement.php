<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\RegexValidator;

class ContractorKppElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('kpp')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(
                (new RegexValidator())
                    ->setRegex('/^[0-9]{4}[0-9A-Z]{2}[0-9]{3}$/')
            )
        ;
    }
}
