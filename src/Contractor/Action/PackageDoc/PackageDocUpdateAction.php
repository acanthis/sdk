<?php

namespace Eds\Contractor\Action\PackageDoc;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\PackageDoc\PackageDocUpdateForm;
use Eds\Contractor\UseCase\PackageDoc\PackageDocUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocUpdateAction
{
    private PackageDocUpdateForm $packageDocUpdateForm;
    private PackageDocUpdate $packageDocUpdate;

    public function __construct(PackageDocUpdateForm $packageDocUpdateForm, PackageDocUpdate $packageDocUpdate)
    {
        $this->packageDocUpdateForm = $packageDocUpdateForm;
        $this->packageDocUpdate = $packageDocUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocUpdateForm->isValid()) {
            throw new ValidationException($this->packageDocUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->packageDocUpdate->execute(
                new UpdateRawDataInput(
                    $this->packageDocUpdateForm->getValue()
                )
            ))
        ;
    }
}
