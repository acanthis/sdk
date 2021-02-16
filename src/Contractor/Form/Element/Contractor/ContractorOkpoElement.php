<?php

namespace Eds\Contractor\Form\Element\Contractor;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\IntegerValidator;
use Nrg\Form\Validator\LengthStringRangeValidator;

class ContractorOkpoElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('okpo')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new IntegerValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(8)
                    ->setMaxLength(10)
            )
        ;
    }
}
