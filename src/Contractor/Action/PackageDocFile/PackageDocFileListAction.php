<?php

namespace Eds\Contractor\Action\PackageDocFile;

use Eds\Contractor\Form\PackageDocFile\PackageDocFileListForm;
use Eds\Contractor\UseCase\PackageDocFile\PackageDocFileList;
use Nrg\Data\Dto\Metadata;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class PackageDocFileListAction
{
    private PackageDocFileListForm $packageDocFileListForm;
    private PackageDocFileList $packageDocFileList;

    public function __construct(PackageDocFileListForm $packageDocFileListForm, PackageDocFileList $packageDocFileList)
    {
        $this->packageDocFileListForm = $packageDocFileListForm;
        $this->packageDocFileList = $packageDocFileList;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        $this->packageDocFileListForm->setValue($event->getRequest()->getBodyParams());

        if (!$this->packageDocFileListForm->isValid()) {
            throw new ValidationException($this->packageDocFileListForm->getErrors());
        }

        $event->getResponse()
            ->setStatusCode(HttpStatus::OK)
            ->setBody(
                $this->packageDocFileList->execute(
                    ...new Metadata($this->packageDocFileListForm->getValue())
                )
            )
        ;
    }
}
