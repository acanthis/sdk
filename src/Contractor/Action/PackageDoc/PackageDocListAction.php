<?php

namespace Eds\Contractor\Action\PackageDoc;

use Eds\Contractor\Form\PackageDoc\PackageDocListForm;
use Eds\Contractor\UseCase\PackageDoc\PackageDocList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocListAction
{
    private PackageDocListForm $packageDocListForm;
    private PackageDocList $packageDocList;

    public function __construct(PackageDocListForm $packageDocListForm, PackageDocList $packageDocList)
    {
        $this->packageDocListForm = $packageDocListForm;
        $this->packageDocList = $packageDocList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocListForm->isValid()) {
            throw new ValidationException($this->packageDocListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocList->execute(
                    ...new Metadata($this->packageDocListForm->getValue())
                )
            )
        ;
    }
}
