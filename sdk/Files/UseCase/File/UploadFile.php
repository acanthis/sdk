<?php

namespace Nrg\Files\UseCase\File;

use Nrg\Files\Persistence\Abstraction\FileRepository;

class UploadFile
{
    private FileRepository $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): void
    {
        $uploadedFile = $data['file'];
        $stream = fopen($uploadedFile->getTmpName(), 'r+');
        $fileName = $uploadedFile->getName();

        $this->repository->writeStream($fileName, $stream);
    }
}
