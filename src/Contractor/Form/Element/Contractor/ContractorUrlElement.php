<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\UrlValidator;

class ContractorUrlElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('url')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new UrlValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(10)
                    ->setMaxLength(150)
            )
        ;
    }
}
