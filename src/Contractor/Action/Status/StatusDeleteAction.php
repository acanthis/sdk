<?php

namespace Eds\Contractor\Action\Status;

use Eds\Contractor\Form\Status\StatusDeleteForm;
use Eds\Contractor\UseCase\Status\StatusDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class StatusDeleteAction
{
    private StatusDeleteForm $statusDeleteForm;
    private StatusDelete $statusDelete;

    public function __construct(StatusDeleteForm $statusDeleteForm, StatusDelete $statusDelete)
    {
        $this->statusDeleteForm = $statusDeleteForm;
        $this->statusDelete = $statusDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->statusDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->statusDeleteForm->isValid()) {
            throw new ValidationException($this->statusDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->statusDelete->execute(
                    $this->statusDeleteForm->getValue()
                )
            )
        ;
    }
}
