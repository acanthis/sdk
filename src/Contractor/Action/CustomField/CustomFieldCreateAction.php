<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Contractor\UseCase\CustomField\CustomFieldCreate;
use Eds\CustomFields\Dto\CustomFieldCreateInput;
use Eds\CustomFields\Form\Element\CustomFieldsElement;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldCreateAction
{
    private CustomFieldsElement $customFieldsElement;
    private CustomFieldCreate $customFieldCreate;

    public function __construct(CustomFieldsElement $customFieldsElement, CustomFieldCreate $customFieldCreate)
    {
        $this->customFieldsElement = $customFieldsElement;
        $this->customFieldCreate = $customFieldCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->customFieldsElement->setValue($event->getRequest()->getBodyParams());

        if (!$this->customFieldsElement->isValid()) {
            throw new ValidationException($this->customFieldsElement->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->customFieldCreate->execute(new CustomFieldCreateInput($this->customFieldsElement->getValue())))
        ;
    }
}
