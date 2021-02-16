<?php

namespace Eds\Contractor\Form\Element\BankAccount;

use Nrg\Form\Element;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\LengthEqualValidator;
use Nrg\Form\Validator\NumericValidator;

class BankAccountBankIdentificationCodeElement extends Element
{
    public function __construct()
    {
        $this
            ->setName('bankIdentificationCode')
            ->addFilter(new TrimFilter())
            ->addFilter(new DefaultNullFilter())
            ->addValidator(new NumericValidator())
            ->addValidator(
                (new LengthEqualValidator())
                    ->setLengths([9])
            )
        ;
    }
}
