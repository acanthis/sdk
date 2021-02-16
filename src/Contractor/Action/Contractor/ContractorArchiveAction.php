<?php

namespace Eds\Contractor\Action\Contractor;

use Eds\Contractor\Form\Contractor\ContractorArchiveForm;
use Eds\Contractor\UseCase\Contractor\ContractorArchive;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContractorArchiveAction
{
    private ContractorArchiveForm $contractorArchiveForm;
    private ContractorArchive $contractorArchive;

    public function __construct(ContractorArchiveForm $contractorArchiveForm, ContractorArchive $contractorArchive)
    {
        $this->contractorArchiveForm = $contractorArchiveForm;
        $this->contractorArchive = $contractorArchive;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contractorArchiveForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contractorArchiveForm->isValid()) {
            throw new ValidationException($this->contractorArchiveForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->contractorArchive->execute(
                    $this->contractorArchiveForm->getValue()
                )
            )
        ;
    }
}
