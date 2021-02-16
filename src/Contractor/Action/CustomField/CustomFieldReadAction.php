<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\CustomField\CustomFieldRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldReadAction
{
    private ReadByUuidForm $customFieldReadForm;
    private CustomFieldRead $customFieldRead;

    public function __construct(ReadByUuidForm $customFieldReadForm, CustomFieldRead $customFieldRead)
    {
        $this->customFieldReadForm = $customFieldReadForm;
        $this->customFieldRead = $customFieldRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->customFieldReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->customFieldReadForm->isValid()) {
            throw new ValidationException($this->customFieldReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->customFieldRead->execute(
                    $this->customFieldReadForm->getValue()
                )
            )
        ;
    }
}
