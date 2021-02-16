<?php

namespace Eds\Contractor\Form\BankAccount;

use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Common\Form\Element\IsDefaultElement;
use Eds\Common\Form\Element\NoteElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankAddressElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankIdentificationCodeElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankNameElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountCheckingAccountElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountCorrespondentAccountElement;
use Eds\Contractor\Form\Element\Contractor\ContractorIdElement;
use Eds\Contractor\Form\Validator\ContractorExistValidator;
use Eds\Contractor\Form\Validator\UniqueBankAccountCheckingAccountValidator;
use Nrg\Form\Form;

class BankAccountCreateForm extends Form
{
    public function __construct(
        ContractorExistValidator $contractorExistValidator,
        UniqueBankAccountCheckingAccountValidator $bankAccountCheckingAccountValidator
    )
    {
        $this
            ->addElement(
                (new ContractorIdElement())
                    ->isRequired()
                    ->addValidator($contractorExistValidator)
            )
            ->addElement(
                (new CreatorIdElement())
                    ->isRequired()
            )
            ->addElement(
                (new BankAccountCheckingAccountElement())
                    ->isRequired()
                    ->addValidator($bankAccountCheckingAccountValidator)
            )
            ->addElement(
                (new IsDefaultElement())
                    ->isRequired()
            )
            ->addElement(new BankAccountBankIdentificationCodeElement())
            ->addElement(new BankAccountCorrespondentAccountElement())
            ->addElement(new BankAccountBankNameElement())
            ->addElement(new BankAccountBankAddressElement())
            ->addElement(new NoteElement())
        ;
    }
}
