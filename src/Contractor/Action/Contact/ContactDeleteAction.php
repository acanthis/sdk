<?php

namespace Eds\Contractor\Action\Contact;

use Eds\Common\Form\DeleteByUuidForm;
use Eds\Contractor\UseCase\Contact\ContactDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContactDeleteAction
{
    private DeleteByUuidForm $contactsDeleteForm;
    private ContactDelete $contactDelete;

    public function __construct(DeleteByUuidForm $contractorContactsDeleteForm, ContactDelete $contactDelete)
    {
        $this->contactsDeleteForm = $contractorContactsDeleteForm;
        $this->contactDelete = $contactDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contactsDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contactsDeleteForm->isValid()) {
            throw new ValidationException($this->contactsDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->contactDelete->execute(
                    $this->contactsDeleteForm->getValue()
                )
            )
        ;
    }
}
