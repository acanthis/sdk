<?php

namespace Eds\Contractor\Action\Group;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\Group\GroupUpdateForm;
use Eds\Contractor\UseCase\Group\GroupUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class GroupUpdateAction
{
    private GroupUpdateForm $groupUpdateForm;
    private GroupUpdate $groupUpdate;

    public function __construct(GroupUpdateForm $groupUpdateForm, GroupUpdate $groupUpdate)
    {
        $this->groupUpdateForm = $groupUpdateForm;
        $this->groupUpdate = $groupUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->groupUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->groupUpdateForm->isValid()) {
            throw new ValidationException($this->groupUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->groupUpdate->execute(
                new UpdateRawDataInput(
                    $this->groupUpdateForm->getValue()
                )
            ))
        ;
    }
}
