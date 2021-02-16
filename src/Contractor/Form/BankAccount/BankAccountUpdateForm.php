<?php

namespace Eds\Contractor\Form\BankAccount;

use Eds\Common\Form\Element\IsDefaultElement;
use Eds\Common\Form\Element\NoteElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankAddressElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankIdentificationCodeElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountBankNameElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountCheckingAccountElement;
use Eds\Contractor\Form\Element\BankAccount\BankAccountCorrespondentAccountElement;
use Eds\Contractor\Form\Element\Contractor\ContractorIdElement;
use Eds\Contractor\Form\Validator\UniqueBankAccountCheckingAccountValidator;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;
use Nrg\Form\Validator\UuidValidator;

class BankAccountUpdateForm extends Form
{
    private UniqueBankAccountCheckingAccountValidator $bankAccountCheckingAccountValidator;

    public function __construct(UniqueBankAccountCheckingAccountValidator $bankAccountCheckingAccountValidator)
    {
        $this->bankAccountCheckingAccountValidator = $bankAccountCheckingAccountValidator;
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new ContractorIdElement())
                    ->isRequired()
                    ->addValidator(new UuidValidator())
            )
            ->addElement((new BankAccountCheckingAccountElement())
                ->isRequired()
            )
            ->addElement(new IsDefaultElement())
            ->addElement(new BankAccountBankIdentificationCodeElement())
            ->addElement(new BankAccountCorrespondentAccountElement())
            ->addElement(new BankAccountBankAddressElement())
            ->addElement(new BankAccountBankNameElement())
            ->addElement(new NoteElement())
        ;
    }

    public function setValue($data): Form
    {
        parent::setValue($data);
        $idElement = $this->getElement('id');
        $contractorIdElement = $this->getElement('contractorId');

        if ($idElement->isValid() && $contractorIdElement->isValid()) {
            $this->getElement('checkingAccount')
                ->addValidator(
                    $this->bankAccountCheckingAccountValidator->setExceptId(
                        $idElement->getValue()
                    )
                )
            ;
        }

        return $this;
    }
}
