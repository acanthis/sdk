<?php

namespace Nrg\Files\Action\File;

use Nrg\Files\Entity\File;
use Nrg\Files\UseCase\File\DeleteFile;
use Nrg\Files\UseCase\File\ReadFile;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Rx\Abstraction\Observer;
use Nrg\Rx\Service\ObserverStub;
use Throwable;

/**
 * Class DownloadFileAction.
 *
 * Downloads a file by a path.
 */
class DownloadFileAction implements Observer
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
     * @var DeleteFile
     */
    private $deleteFile;

    /**
     * @var bool
     */
    private $deleteTempFile = false;

    /**
     * @var array
     */
    private $params;

    /**
     * @param ReadFile $readFile
     */
    public function __construct(ReadFile $readFile, DeleteFile $deleteFile)
    {
        $this->readFile = $readFile;
        $this->deleteFile = $deleteFile;
    }

    /**
     * Downloads a file by a path.
     *
     * @param HttpExchangeEvent $event
     */
    public function onNext($event)
    {
        $this->params = $event->getRequest()->getQueryParams();

        $this->file = $this->readFile->execute($this->params);
        $this->deleteTempFile = $event->getRequest()->getQueryParam('deleteTempFile', false);
        $fileName = $event->getRequest()->getQueryParam('fileName', $this->file->getPath()->getFileName());

        $event->getResponse()
            ->setHeader('Content-Description', 'File Transfer')
            ->setHeader('Content-Type', 'application/octet-stream')
            ->setHeader(
                'Content-Disposition',
                'attachment; filename="'.$fileName.'"'
            )
            ->setHeader('Expires', '0')
            ->setHeader('Cache-Control', 'must-revalidate')
            ->setHeader('Pragma', 'public')
            ->setHeader('Content-Length', $this->file->getSize());
    }

    public function onComplete()
    {
        if (ob_get_level()) {
            ob_end_clean();
        }

        echo $this->file->getContents();

        $this->clear();
    }

    public function onError(Throwable $throwable, $event)
    {
        $this->clear();
    }

    private function clear():void
    {
        if ($this->deleteTempFile) {
            $this->deleteFile->execute($this->params);
        }
    }
}
