<?php

namespace Eds\Contractor\Action\Contact;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\Contact\ContactRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class ContactReadAction
{
    private ReadByUuidForm $contactReadForm;
    private ContactRead $contactRead;

    public function __construct(ReadByUuidForm $contactReadForm, ContactRead $contactRead)
    {
        $this->contactReadForm = $contactReadForm;
        $this->contactRead = $contactRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->contactReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->contactReadForm->isValid()) {
            throw new ValidationException($this->contactReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->contactRead->execute(
                    $this->contactReadForm->getValue()
                )
            )
        ;
    }
}
