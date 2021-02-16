<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Contractor\Form\Contractor\ContractorListForm;
use Eds\Contractor\UseCase\Contractor\ContractorList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorListAction
{
    private ContractorListForm $contractorListForm;
    private ContractorList $contractorList;

    public function __construct(ContractorListForm $contractorListForm, ContractorList $contractorList)
    {
        $this->contractorListForm = $contractorListForm;
        $this->contractorList = $contractorList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contractorListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contractorListForm->isValid()) {
            throw new ValidationException($this->contractorListForm->getErrors());
        }

        $metadata = new Metadata($this->contractorListForm->getValue());
        /*$restrictFilter = (new Filter())
            ->addCondition($this->permission->createCondition())
            ->addFilter($metadata->getFilter())
        ;*/
//todo:        $metadata->setFilter($restrictFilter);

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->contractorList->execute(...$metadata))
        ;
    }
}
