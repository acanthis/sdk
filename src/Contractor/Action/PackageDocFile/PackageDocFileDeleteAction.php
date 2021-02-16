<?php

namespace Eds\Contractor\Action\PackageDocFile;

use Eds\Contractor\Form\PackageDocFile\PackageDocFileDeleteForm;
use Eds\Contractor\UseCase\PackageDocFile\PackageDocFileDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocFileDeleteAction
{
    private PackageDocFileDeleteForm $packageDocFileDeleteForm;
    private PackageDocFileDelete $packageDocFileDelete;

    public function __construct(PackageDocFileDeleteForm $packageDocFileDeleteForm, PackageDocFileDelete $packageDocFileDelete)
    {
        $this->packageDocFileDeleteForm = $packageDocFileDeleteForm;
        $this->packageDocFileDelete = $packageDocFileDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocFileDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocFileDeleteForm->isValid()) {
            throw new ValidationException($this->packageDocFileDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocFileDelete->execute(
                    $this->packageDocFileDeleteForm->getValue()
                )
            )
        ;
    }
}
