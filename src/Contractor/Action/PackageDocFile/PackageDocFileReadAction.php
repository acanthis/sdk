<?php

namespace Eds\Contractor\Action\PackageDocFile;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\PackageDocFile\PackageDocFileRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocFileReadAction
{
    private ReadByUuidForm $packageDocFileReadForm;
    private PackageDocFileRead $packageDocFileRead;

    public function __construct(ReadByUuidForm $packageDocFileReadForm, PackageDocFileRead $packageDocFileRead)
    {
        $this->packageDocFileReadForm = $packageDocFileReadForm;
        $this->packageDocFileRead = $packageDocFileRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocFileReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocFileReadForm->isValid()) {
            throw new ValidationException($this->packageDocFileReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocFileRead->execute(
                    $this->packageDocFileReadForm->getValue()
                )
            )
        ;
    }
}
