<?php

namespace Nrg\Auth\Action;

use Nrg\Auth\Form\UserListForm;
use Nrg\Auth\UseCase\UserList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class UserListAction
{
    private UserList $userList;

    private UserListForm $userListForm;

    public function __construct(UserList $userList, UserListForm $userListForm)
    {
        $this->userList = $userList;
        $this->userListForm = $userListForm;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->userListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->userListForm->isValid()) {
            throw new ValidationException($this->userListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->userList->execute(
                    ...new Metadata($this->userListForm->getValue())
                )
            );
    }
}
