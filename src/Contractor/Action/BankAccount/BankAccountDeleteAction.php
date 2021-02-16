<?php

namespace Eds\Contractor\Action\BankAccount;

use Eds\Common\Form\DeleteByUuidForm;
use Eds\Contractor\UseCase\BankAccount\BankAccountDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class BankAccountDeleteAction
{
    private DeleteByUuidForm $bankAccountsDeleteForm;
    private BankAccountDelete $bankAccountDelete;

    public function __construct(DeleteByUuidForm $bankAccountsDeleteForm, BankAccountDelete $bankAccountDelete)
    {
        $this->bankAccountsDeleteForm = $bankAccountsDeleteForm;
        $this->bankAccountDelete = $bankAccountDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->bankAccountsDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->bankAccountsDeleteForm->isValid()) {
            throw new ValidationException($this->bankAccountsDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->bankAccountDelete->execute(
                    $this->bankAccountsDeleteForm->getValue()
                )
            )
        ;
    }
}
