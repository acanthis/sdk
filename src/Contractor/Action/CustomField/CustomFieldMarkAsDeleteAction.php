<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\CustomField\CustomFieldMarkAsDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldMarkAsDeleteAction
{
    private ReadByUuidForm $customFieldReadForm;
    private CustomFieldMarkAsDelete $customFieldMarkAsDelete;

    public function __construct(ReadByUuidForm $customFieldReadForm, CustomFieldMarkAsDelete $customFieldMarkAsDelete)
    {
        $this->customFieldReadForm = $customFieldReadForm;
        $this->customFieldMarkAsDelete = $customFieldMarkAsDelete;
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
                $this->customFieldMarkAsDelete->execute(
                    $this->customFieldReadForm->getValue()
                )
            )
        ;
    }
}
