<?php

namespace Eds\Contractor\Action\BankAccount;

use Eds\Contractor\Form\BankAccount\BankAccountCreateForm;
use Eds\Contractor\UseCase\BankAccount\BankAccountCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class BankAccountCreateAction
{
    private BankAccountCreateForm $bankAccountCreateForm;
    private BankAccountCreate $bankAccountCreate;

    public function __construct(BankAccountCreateForm $bankAccountCreateForm, BankAccountCreate $bankAccountCreate)
    {
        $this->bankAccountCreateForm = $bankAccountCreateForm;
        $this->bankAccountCreate = $bankAccountCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->bankAccountCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->bankAccountCreateForm->isValid()) {
            throw new ValidationException($this->bankAccountCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->bankAccountCreate->execute($this->bankAccountCreateForm->getValue()))
        ;
    }
}
