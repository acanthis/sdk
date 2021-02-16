<?php

namespace Eds\Contractor\Action\Group;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\Group\GroupRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class GroupReadAction
{
    private ReadByUuidForm $groupReadForm;
    private GroupRead $groupRead;

    public function __construct(ReadByUuidForm $groupReadForm, GroupRead $groupRead)
    {
        $this->groupReadForm = $groupReadForm;
        $this->groupRead = $groupRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->groupReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->groupReadForm->isValid()) {
            throw new ValidationException($this->groupReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->groupRead->execute(
                    $this->groupReadForm->getValue()
                )
            )
        ;
    }
}
