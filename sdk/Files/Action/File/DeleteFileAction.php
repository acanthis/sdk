<?php

namespace Nrg\Files\Action\File;

use Nrg\Files\UseCase\File\DeleteFile;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;
use Nrg\Rx\Abstraction\Observer;
use Nrg\Rx\Service\ObserverStub;

/**
 * Class DeleteFileAction.
 *
 * Deletes a file.
 */
class DeleteFileAction implements Observer
{
    use ObserverStub;

    /**
     * @var DeleteFileAction
     */
    private $deleteFile;

    /**
     * @param DeleteFile $deleteFile
     */
    public function __construct(DeleteFile $deleteFile)
    {
        $this->deleteFile = $deleteFile;
    }

    /**
     * Copies a file.
     *
     * @param HttpExchangeEvent $event
     */
    public function onNext($event)
    {
        $params = $event->getRequest()->getBodyParams();

        $this->deleteFile->execute($params);

        $event->getResponse()->setStatus(
            new HttpStatus(HttpStatus::NO_CONTENT)
        );
    }
}
