<?php

namespace Eds\Contractor\Action\BankAccount;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\BankAccount\BankAccountUpdateForm;
use Eds\Contractor\UseCase\BankAccount\BankAccountUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class BankAccountUpdateAction
{
    private BankAccountUpdateForm $bankAccountUpdateForm;
    private BankAccountUpdate $bankAccountUpdate;

    public function __construct(BankAccountUpdateForm $contractorBankAccountUpdateForm, BankAccountUpdate $contractorBankAccountUpdate)
    {
        $this->bankAccountUpdateForm = $contractorBankAccountUpdateForm;
        $this->bankAccountUpdate = $contractorBankAccountUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->bankAccountUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->bankAccountUpdateForm->isValid()) {
            throw new ValidationException($this->bankAccountUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->bankAccountUpdate->execute(
                new UpdateRawDataInput(
                    $this->bankAccountUpdateForm->getValue()
                )
            ))
        ;
    }
}
