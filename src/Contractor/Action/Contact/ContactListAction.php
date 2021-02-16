<?php

namespace Eds\Contractor\Action\Contact;

use Eds\Contractor\Form\Contact\ContactListForm;
use Eds\Contractor\UseCase\Contact\ContactList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContactListAction
{
    private ContactListForm $contactListForm;
    private ContactList $contactList;

    public function __construct(ContactListForm $contactListForm, ContactList $contactList)
    {
        $this->contactListForm = $contactListForm;
        $this->contactList = $contactList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contactListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contactListForm->isValid()) {
            throw new ValidationException($this->contactListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->contactList->execute(
                    ...new Metadata($this->contactListForm->getValue())
                )
            )
        ;
    }
}
