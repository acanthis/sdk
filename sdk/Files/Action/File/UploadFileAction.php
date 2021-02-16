<?php

namespace Nrg\Files\Action\File;

use Nrg\Files\UseCase\File\UploadFile;
use Nrg\Http\Event\HttpExchangeEvent;
use Nrg\Http\Exception\ValidationException;
use Nrg\Http\Value\HttpStatus;

class UploadFileAction
{
    private $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    public function onNext(HttpExchangeEvent $event)
    {
        if ($this->isLargeFileUpload()) {
            throw new ValidationException(['file' => 'Large file size']);
        } else {
            $params = $event->getRequest()->getBodyParams();
            $params['file'] = $event->getRequest()->getUploadedFiles()['file'];

            $event->getResponse()
                ->setStatusCode(HttpStatus::CREATED)
                ->setBody($this->uploadFile->execute($params));
        }
    }

    private function isLargeFileUpload(): bool
    {
        $result = false;
        $lastError = error_get_last();

        // If uploading long file
        if (null !== $lastError && E_WARNING === $lastError['type'] && empty($_POST) && empty($_FILES)) {
            $result = true;
        }

        return $result;
    }
}
