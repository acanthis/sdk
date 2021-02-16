<?php

namespace Eds\Contractor\Action\PackageDoc;

use Eds\Contractor\Form\PackageDoc\PackageDocCreateForm;
use Eds\Contractor\UseCase\PackageDoc\PackageDocCreate;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocCreateAction
{
    private PackageDocCreateForm $packageDocCreateForm;
    private PackageDocCreate $packageDocCreate;

    public function __construct(PackageDocCreateForm $packageDocCreateForm, PackageDocCreate $packageDocCreate)
    {
        $this->packageDocCreateForm = $packageDocCreateForm;
        $this->packageDocCreate = $packageDocCreate;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocCreateForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocCreateForm->isValid()) {
            throw new ValidationException($this->packageDocCreateForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::CREATED)
            ->setBody($this->packageDocCreate->execute($this->packageDocCreateForm->getValue()))
        ;
    }
}
