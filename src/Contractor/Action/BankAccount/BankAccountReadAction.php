<?php

namespace Eds\Contractor\Action\BankAccount;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\BankAccount\BankAccountRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class BankAccountReadAction
{
    private ReadByUuidForm $bankAccountsReadForm;
    private BankAccountRead $bankAccountRead;

    public function __construct(ReadByUuidForm $bankAccountsReadForm, BankAccountRead $bankAccountRead)
    {
        $this->bankAccountsReadForm = $bankAccountsReadForm;
        $this->bankAccountRead = $bankAccountRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->bankAccountsReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->bankAccountsReadForm->isValid()) {
            throw new ValidationException($this->bankAccountsReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->bankAccountRead->execute(
                    $this->bankAccountsReadForm->getValue()
                )
            )
        ;
    }
}
