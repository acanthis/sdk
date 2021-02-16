<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Form\UserDeleteForm;
use Nrg\Auth\UseCase\UserDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class UserDeleteAction
{
    private UserDeleteForm $userDeleteForm;

    private UserDelete $userDelete;

    public function __construct(UserDeleteForm $userDeleteForm, UserDelete $userDelete)
    {
        $this->userDeleteForm = $userDeleteForm;
        $this->userDelete = $userDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->userDeleteForm->setValue($event->getRequest()->getBodyParams());

        if ($this->userDeleteForm->isValid()) {
            throw new ValidationException($this->userDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->userDelete->execute($this->userDeleteForm->getValue()))
        ;
    }
}
