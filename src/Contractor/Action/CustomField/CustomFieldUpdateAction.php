<?php

namespace Eds\Contractor\Action\CustomField;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\UseCase\CustomField\CustomFieldUpdate;
use Eds\CustomFields\Form\DocumentCustomFieldsUpdateForm;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class CustomFieldUpdateAction
{
    private DocumentCustomFieldsUpdateForm $customFieldsUpdateForm;
    private CustomFieldUpdate $customFieldUpdate;

    public function __construct(DocumentCustomFieldsUpdateForm $statusUpdateForm, CustomFieldUpdate $customFieldUpdate)
    {
        $this->customFieldsUpdateForm = $statusUpdateForm;
        $this->customFieldUpdate = $customFieldUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->customFieldsUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->customFieldsUpdateForm->isValid()) {
            throw new ValidationException($this->customFieldsUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->customFieldUpdate->execute(
                new UpdateRawDataInput(
                    $this->customFieldsUpdateForm->getValue()
                )
            ))
        ;
    }
}
