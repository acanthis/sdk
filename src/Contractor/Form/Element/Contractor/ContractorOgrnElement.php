<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Eds\Contractor\Form\Validator\OgrnChecksumValidator as OgrnChecksumValidator;
use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\IntegerValidator;
use Nrg\Form\Validator\LengthEqualValidator;

class ContractorOgrnElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('ogrn')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new IntegerValidator())
            ->addValidator(
                (new LengthEqualValidator())
                    ->addLength(13)
            )
            ->addValidator(new OgrnChecksumValidator())
        ;
    }
}
