<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Eds\Contractor\Form\Validator\InnChecksumValidator;
use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthEqualValidator;
use Nrg\Form\Validator\NumericValidator;

class ContractorInnElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('inn')
            ->addFilter(new TrimFilter())
            ->addValidator(new NumericValidator())
            ->addValidator(
                (new LengthEqualValidator())
                    ->setLengths([10, 12])
            )
            ->addValidator(new InnChecksumValidator())
        ;
    }
}
