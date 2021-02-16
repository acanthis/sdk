<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\Contractor\ContractorRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorReadAction
{
    private ReadByUuidForm $readForm;
    private ContractorRead $contractorRead;

    public function __construct(ReadByUuidForm $readForm, ContractorRead $contractorRead)
    {
        $this->readForm = $readForm;
        $this->contractorRead = $contractorRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->readForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->readForm->isValid()) {
            throw new ValidationException($this->readForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->contractorRead->execute($this->readForm->getValue()))
        ;
    }
}
