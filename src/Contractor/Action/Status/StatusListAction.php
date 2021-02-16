<?php

namespace Eds\Contractor\Action\Status;

use Eds\Contractor\Form\Status\StatusListForm;
use Eds\Contractor\UseCase\Status\StatusList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class StatusListAction
{
    private StatusListForm $statusListForm;
    private StatusList $statusList;

    public function __construct(StatusListForm $statusListForm, StatusList $statusList)
    {
        $this->statusListForm = $statusListForm;
        $this->statusList = $statusList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->statusListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->statusListForm->isValid()) {
            throw new ValidationException($this->statusListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->statusList->execute(
                    ...new Metadata($this->statusListForm->getValue())
                )
            )
        ;
    }
}
