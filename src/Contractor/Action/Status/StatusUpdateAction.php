<?php

namespace Eds\Contractor\Action\Status;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\Status\StatusUpdateForm;
use Eds\Contractor\UseCase\Status\StatusUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class StatusUpdateAction
{
    private StatusUpdateForm $statusUpdateForm;
    private StatusUpdate $statusUpdate;

    public function __construct(StatusUpdateForm $statusUpdateForm, StatusUpdate $statusUpdate)
    {
        $this->statusUpdateForm = $statusUpdateForm;
        $this->statusUpdate = $statusUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->statusUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->statusUpdateForm->isValid()) {
            throw new ValidationException($this->statusUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->statusUpdate->execute(
                new UpdateRawDataInput(
                    $this->statusUpdateForm->getValue()
                )
            ))
        ;
    }
}
