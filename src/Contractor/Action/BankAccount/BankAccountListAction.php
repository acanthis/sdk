<?php

namespace Eds\Contractor\Action\BankAccount;

use Eds\Contractor\Form\BankAccount\BankAccountListForm;
use Eds\Contractor\UseCase\BankAccount\BankAccountList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class BankAccountListAction
{
    private BankAccountListForm $bankAccountListForm;
    private BankAccountList $bankAccountList;

    public function __construct(BankAccountListForm $bankAccountListForm, BankAccountList $bankAccountList)
    {
        $this->bankAccountListForm = $bankAccountListForm;
        $this->bankAccountList = $bankAccountList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->bankAccountListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->bankAccountListForm->isValid()) {
            throw new ValidationException($this->bankAccountListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->bankAccountList->execute(
                    ...new Metadata($this->bankAccountListForm->getValue())
                )
            )
        ;
    }
}
