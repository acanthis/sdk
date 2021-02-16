<?php

namespace Eds\Contractor\Action\Group;

use Eds\Contractor\Form\Group\GroupListForm;
use Eds\Contractor\UseCase\Group\GroupList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class GroupListAction
{
    private GroupListForm $groupListForm;
    private GroupList $groupList;

    public function __construct(GroupListForm $groupListForm, GroupList $groupList)
    {
        $this->groupListForm = $groupListForm;
        $this->groupList = $groupList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->groupListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->groupListForm->isValid()) {
            throw new ValidationException($this->groupListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->groupList->execute(
                    ...new Metadata($this->groupListForm->getValue())
                )
            )
        ;
    }
}
