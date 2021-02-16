<?php

namespace Eds\Contractor\Action\PackageDocFile;

use Eds\Contractor\Form\PackageDocFile\PackageDocFileCreateForm;
use Eds\Contractor\UseCase\PackageDocFile\PackageDocFileCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocFileCreateAction
{
    private PackageDocFileCreateForm $packageDocFileCreateForm;
    private PackageDocFileCreate $packageDocFileCreate;

    public function __construct(PackageDocFileCreateForm $packageDocFileCreateForm, PackageDocFileCreate $packageDocFileCreate)
    {
        $this->packageDocFileCreateForm = $packageDocFileCreateForm;
        $this->packageDocFileCreate = $packageDocFileCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocFileCreateForm->setValue(
            array_merge(
                $event->getRequest()->getBodyParams(),
                $event->getRequest()->getUploadedFiles()
            )
        );

        if (!$this->packageDocFileCreateForm->isValid()) {
            throw new ValidationException($this->packageDocFileCreateForm->getErrors());
        }

        $this->packageDocFileCreate->execute($this->packageDocFileCreateForm->getValue());

        $event->getResponse()
            ->setStatusCode(HttpStatus::NO_CONTENT)
        ;
    }
}
