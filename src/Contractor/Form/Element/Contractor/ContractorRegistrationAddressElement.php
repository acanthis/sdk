<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\StringValidator;

class ContractorRegistrationAddressElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('registrationAddress')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new StringValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(5)
                    ->setMaxLength(255)
            )
        ;
    }
}
