<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Dto\UserUpdateInput;
use Nrg\Auth\Form\UserUpdateForm;
use Nrg\Auth\UseCase\UserUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class UserUpdateAction
{
    private UserUpdateForm $updateForm;

    private UserUpdate $userUpdate;

    public function __construct(UserUpdateForm $userUpdateForm, UserUpdate $userUpdate)
    {
        $this->updateForm = $userUpdateForm;
        $this->userUpdate = $userUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->updateForm->setValue($event->getRequest()->getBodyParams());

        if ($this->updateForm->isValid()) {
            throw new ValidationException($this->updateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->userUpdate->execute(new UserUpdateInput($this->updateForm->getValue()))
            )
        ;
    }
}
