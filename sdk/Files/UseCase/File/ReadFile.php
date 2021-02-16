<?php

namespace Nrg\Files\UseCase\File;

use Nrg\Files\Entity\File;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Data\Exception\EntityNotFoundException;

/**
 * Class ReadFile.
 *
 * Service to read a file.
 */
class ReadFile
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Reads a file by path.
     *
     * data [
     *  'path' => '/folder1/file.txt',       // required
     * ]
     *
     * @param array $data
     *
     * @return File
     */
    public function execute(array $data): File
    {
        $path = new Path($data['path']);

        if (!$this->repository->has($path)) {
            throw new EntityNotFoundException(sprintf('File \'%s\' is not exists or it\'s not readable', $path));
        }

        return $this->repository->readFile($path);
    }
}
