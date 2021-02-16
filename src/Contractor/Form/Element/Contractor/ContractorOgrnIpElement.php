<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Eds\Contractor\Form\Validator\OgrnipChecksumValidator;
use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\IntegerValidator;
use Nrg\Form\Validator\LengthEqualValidator;

class ContractorOgrnIpElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('ogrnIp')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new IntegerValidator())
            ->addValidator(
                (new LengthEqualValidator())
                    ->addLength(15)
            )
            ->addValidator(new OgrnipChecksumValidator())
        ;
    }
}
