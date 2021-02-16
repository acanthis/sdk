<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Contractor\Form\Contractor\ContractorCreateForm;
use Eds\Contractor\UseCase\Contractor\ContractorCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorCreateAction
{
    private ContractorCreateForm $contractorCreateForm;
    private ContractorCreate $contractorCreate;

    public function __construct(ContractorCreateForm $contractorCreateForm, ContractorCreate $contractorCreate)
    {
        $this->contractorCreateForm = $contractorCreateForm;
        $this->contractorCreate = $contractorCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contractorCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contractorCreateForm->isValid()) {
            throw new ValidationException($this->contractorCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->contractorCreate->execute($this->contractorCreateForm->getValue()))
        ;
    }
}
