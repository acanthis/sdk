<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Contractor\UseCase\CustomField\CustomFieldList;
use Eds\CustomFields\Form\CustomFieldsListForm;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldListAction
{
    private CustomFieldsListForm $customFieldsListForm;
    private CustomFieldList $customFieldList;

    public function __construct(CustomFieldsListForm $customFieldsListForm, CustomFieldList $customFieldList)
    {
        $this->customFieldsListForm = $customFieldsListForm;
        $this->customFieldList = $customFieldList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->customFieldsListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->customFieldsListForm->isValid()) {
            throw new ValidationException($this->customFieldsListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->customFieldList->execute(
                    ...new Metadata($this->customFieldsListForm->getValue())
                )
            )
        ;
    }
}
