<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\CustomField\CustomFieldUnMarkAsDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldUnMarkAsDeleteAction
{
    private ReadByUuidForm $customFieldReadForm;
    private CustomFieldUnMarkAsDelete $customFieldUnMarkAsDelete;

    public function __construct(ReadByUuidForm $customFieldReadForm, CustomFieldUnMarkAsDelete $customFieldUnMarkAsDelete)
    {
        $this->customFieldReadForm = $customFieldReadForm;
        $this->customFieldUnMarkAsDelete = $customFieldUnMarkAsDelete;
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
                $this->customFieldUnMarkAsDelete->execute(
                    $this->customFieldReadForm->getValue()
                )
            )
        ;
    }
}
