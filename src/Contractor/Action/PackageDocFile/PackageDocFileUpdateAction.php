<?php

namespace Eds\Contractor\Action\PackageDocFile;

use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Form\PackageDocFile\PackageDocFileUpdateForm;
use Eds\Contractor\UseCase\PackageDocFile\PackageDocFileUpdate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocFileUpdateAction
{
    private PackageDocFileUpdateForm $packageDocFileUpdateForm;
    private PackageDocFileUpdate $packageDocFileUpdate;

    public function __construct(PackageDocFileUpdateForm $packageDocFileUpdateForm, PackageDocFileUpdate $packageDocFileUpdate)
    {
        $this->packageDocFileUpdateForm = $packageDocFileUpdateForm;
        $this->packageDocFileUpdate = $packageDocFileUpdate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocFileUpdateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocFileUpdateForm->isValid()) {
            throw new ValidationException($this->packageDocFileUpdateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody($this->packageDocFileUpdate->execute(
                new UpdateRawDataInput(
                    $this->packageDocFileUpdateForm->getValue()
                )
            ))
        ;
    }
}
