<?php

namespace Eds\Contractor\Action\Status;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\Status\StatusRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class StatusReadAction
{
    private ReadByUuidForm $statusReadForm;
    private StatusRead $statusRead;

    public function __construct(ReadByUuidForm $statusReadForm, StatusRead $statusRead)
    {
        $this->statusReadForm = $statusReadForm;
        $this->statusRead = $statusRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->statusReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->statusReadForm->isValid()) {
            throw new ValidationException($this->statusReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->statusRead->execute(
                    $this->statusReadForm->getValue()
                )
            )
        ;
    }
}
