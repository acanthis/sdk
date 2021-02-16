<?php

namespace Eds\Contractor\Action\PackageDoc;

use Eds\Common\Form\DeleteByUuidForm;
use Eds\Contractor\UseCase\PackageDoc\PackageDocDelete;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocDeleteAction
{
    private DeleteByUuidForm $packageDocDeleteForm;
    private PackageDocDelete $packageDocDelete;

    public function __construct(DeleteByUuidForm $packageDocDeleteForm, PackageDocDelete $packageDocDelete)
    {
        $this->packageDocDeleteForm = $packageDocDeleteForm;
        $this->packageDocDelete = $packageDocDelete;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocDeleteForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocDeleteForm->isValid()) {
            throw new ValidationException($this->packageDocDeleteForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocDelete->execute(
                    $this->packageDocDeleteForm->getValue()
                )
            )
        ;
    }
}
