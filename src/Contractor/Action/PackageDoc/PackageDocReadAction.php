<?php

namespace Eds\Contractor\Action\PackageDoc;

use Eds\Common\Form\ReadByUuidForm;
use Eds\Contractor\UseCase\PackageDoc\PackageDocRead;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocReadAction
{
    private ReadByUuidForm $packageDocReadForm;
    private PackageDocRead $packageDocRead;

    public function __construct(ReadByUuidForm $packageDocReadForm, PackageDocRead $packageDocRead)
    {
        $this->packageDocReadForm = $packageDocReadForm;
        $this->packageDocRead = $packageDocRead;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocReadForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocReadForm->isValid()) {
            throw new ValidationException($this->packageDocReadForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocRead->execute(
                    $this->packageDocReadForm->getValue()
                )
            )
        ;
    }
}
