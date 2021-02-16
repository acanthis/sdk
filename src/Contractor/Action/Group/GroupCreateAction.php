<?php

namespace Eds\Contractor\Action\Group;

use Eds\Contractor\Form\Group\GroupCreateForm;
use Eds\Contractor\UseCase\Group\GroupCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class GroupCreateAction
{
    private GroupCreateForm $groupCreateForm;
    private GroupCreate $groupCreate;

    public function __construct(GroupCreateForm $groupCreateForm, GroupCreate $groupCreate)
    {
        $this->groupCreateForm = $groupCreateForm;
        $this->groupCreate = $groupCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->groupCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->groupCreateForm->isValid()) {
            throw new ValidationException($this->groupCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->groupCreate->execute($this->groupCreateForm->getValue()))
        ;
    }
}
