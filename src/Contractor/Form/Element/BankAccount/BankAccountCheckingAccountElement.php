<?php

namespace Eds\Contractor\Form\Element\BankAccount;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthStringRangeValidator;
use Nrg\Form\Validator\NumericValidator;

class BankAccountCheckingAccountElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('checkingAccount')
            ->addFilter(new TrimFilter())
            ->addValidator(new NumericValidator())
            ->addValidator(
                (new LengthStringRangeValidator())
                    ->setMinLength(1)
                    ->setMaxLength(20)
            )
        ;
    }
}
