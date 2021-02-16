<?php

namespace Eds\Contractor\Action\Status;

use Eds\Contractor\Form\Status\StatusCreateForm;
use Eds\Contractor\UseCase\Status\StatusCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class StatusCreateAction
{
    private StatusCreateForm $statusCreateForm;
    private StatusCreate $statusCreate;

    public function __construct(StatusCreateForm $statusCreateForm, StatusCreate $statusCreate)
    {
        $this->statusCreateForm = $statusCreateForm;
        $this->statusCreate = $statusCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->statusCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->statusCreateForm->isValid()) {
            throw new ValidationException($this->statusCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->statusCreate->execute($this->statusCreateForm->getValue()))
        ;
    }
}
