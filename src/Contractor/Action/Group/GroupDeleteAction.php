<?php

namespace Eds\Contractor\Action\Group;

use Eds\Common\Form\DeleteByUuidForm;
use Eds\Contractor\UseCase\Group\GroupDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class GroupDeleteAction
{
    private DeleteByUuidForm $groupDeleteForm;
    private GroupDelete $groupDelete;

    public function __construct(DeleteByUuidForm $groupDeleteForm, GroupDelete $groupDelete)
    {
        $this->groupDeleteForm = $groupDeleteForm;
        $this->groupDelete = $groupDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->groupDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->groupDeleteForm->isValid()) {
            throw new ValidationException($this->groupDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->groupDelete->execute(
                    $this->groupDeleteForm->getValue()
                )
            )
        ;
    }
}
