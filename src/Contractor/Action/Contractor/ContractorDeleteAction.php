<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Common\Form\DeleteByIdForm;
use Eds\Contractor\UseCase\Contractor\ContractorDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorDeleteAction
{
    private DeleteByIdForm $contractorDeleteForm;
    private ContractorDelete $contractorDelete;

    public function __construct(DeleteByIdForm $contractorDeleteForm, ContractorDelete $contractorDelete)
    {
        $this->contractorDeleteForm = $contractorDeleteForm;
        $this->contractorDelete = $contractorDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contractorDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contractorDeleteForm->isValid()) {
            throw new ValidationException($this->contractorDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->contractorDelete->execute(
                    $this->contractorDeleteForm->getValue()
                )
            )
        ;
    }
}
