<?php

namespace Nrg\Files\Action\File;

use Nrg\Files\Entity\File;
use Nrg\Files\Entity\Hyperlink;
use Nrg\Files\UseCase\File\ReadFile;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Value\HttpStatus;
use Nrg\Rx\Abstraction\Observer;
use Nrg\Rx\Service\ObserverStub;

/**
 * Class OpenFileAction.
 *
 * Opens a file by a path.
 */
class OpenFileAction implements Observer
{
    use ObserverStub;

    /**
     * @var File
     */
    private $file;

    /**
     * @var ReadFile
     */
    private $readFile;

    /**
     * @param ReadFile $readFile
     */
    public function __construct(ReadFile $readFile)
    {
        $this->readFile = $readFile;
    }

    /**
     * Opens a file by a path.
     *
     * @param HttpExchangeEvent $event
     */
    public function onNext($event)
    {
        $params = $event->getRequest()->getQueryParams();

        $this->file = $this->readFile->execute($params);

        if ($this->file instanceof Hyperlink) {
            $event->getResponse()
                ->setStatus(new HttpStatus(HttpStatus::FOUND))
                ->setHeader('Location', (string)$this->file->getUrl());
        } else {
            $event->getResponse()
                ->setHeader('Content-Type', $this->file->getMimeType().'; charset=utf-8');
        }
    }

    public function onComplete()
    {
        if ($this->file instanceof Hyperlink) {
            return;
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        echo $this->file->getContents();
    }
}
