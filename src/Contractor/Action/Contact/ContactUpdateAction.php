<?php

namespace Eds\Contractor\Action\Contact;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\Contact\ContactUpdateForm;
use Eds\Contractor\UseCase\Contact\ContactUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContactUpdateAction
{
    private ContactUpdateForm $contactUpdateForm;
    private ContactUpdate $contactUpdate;

    public function __construct(ContactUpdateForm $contactUpdateForm, ContactUpdate $contactUpdate)
    {
        $this->contactUpdateForm = $contactUpdateForm;
        $this->contactUpdate = $contactUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contactUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contactUpdateForm->isValid()) {
            throw new ValidationException($this->contactUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->contactUpdate->execute(
                new UpdateRawDataInput(
                    $this->contactUpdateForm->getValue()
                )
            ))
        ;
    }
}
