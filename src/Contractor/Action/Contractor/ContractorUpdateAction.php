<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Contractor\Dto\ContractorUpdateRawDataInput;
use Eds\Contractor\Form\Contractor\ContractorUpdateForm;
use Eds\Contractor\UseCase\Contractor\ContractorUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorUpdateAction
{
    private ContractorUpdateForm $contractorUpdateForm;
    private ContractorUpdate $contractorUpdate;

    public function __construct(ContractorUpdateForm $contractorUpdateForm, ContractorUpdate $contractorUpdate)
    {
        $this->contractorUpdateForm = $contractorUpdateForm;
        $this->contractorUpdate = $contractorUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contractorUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contractorUpdateForm->isValid()) {
            throw new ValidationException($this->contractorUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->contractorUpdate->execute(new ContractorUpdateRawDataInput($this->contractorUpdateForm->getValue())))
        ;
    }
}
