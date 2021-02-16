<?php

namespace Eds\Contractor\Action\Contact;

use Eds\Contractor\Form\Contact\ContactCreateForm;
use Eds\Contractor\UseCase\Contact\ContactCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContactCreateAction
{
    private ContactCreateForm $contactCreateForm;
    private ContactCreate $contactCreate;

    public function __construct(ContactCreateForm $contactCreateForm, ContactCreate $contactCreate)
    {
        $this->contactCreateForm = $contactCreateForm;
        $this->contactCreate = $contactCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contactCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contactCreateForm->isValid()) {
            throw new ValidationException($this->contactCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->contactCreate->execute($this->contactCreateForm->getValue()))
        ;
    }
}
