<?php

namespace Nrg\Files\UseCase\File;

use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;

/**
 * Class DeleteFile.
 *
 * Service to delete file.
 */
class DeleteFile
{
    /**
     * @var FileRepository
     */
    private $repository;


    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @example for the data:
     * [
     *  'path' => '/folder1/file.txt',  // required
     * ]
     *
     * @param array $data
     *
     */
    public function execute(array $data): void
    {
        $path = new Path($data['path']);

        $this->repository->deleteFile($path);
    }
}
