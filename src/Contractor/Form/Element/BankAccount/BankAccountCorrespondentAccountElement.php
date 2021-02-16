<?php

namespace Eds\Contractor\Form\Element\BankAccount;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\NumericValidator;

class BankAccountCorrespondentAccountElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('correspondentAccount')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new NumericValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(20)
            )
        ;
    }
}
