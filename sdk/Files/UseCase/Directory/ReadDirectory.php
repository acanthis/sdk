<?php

namespace Nrg\Files\UseCase\Directory;

use Nrg\Files\Entity\Directory;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Data\Exception\EntityNotFoundException;

/**
 * Class ReadDirectory.
 *
 * Service to read a directory.
 */
class ReadDirectory
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
     * Reads a directory by path.
     *
     * data [
     *  'path' => '/folder1/folder2',       // required
     * ]
     *
     * @param array $data
     *
     * @return Directory
     */
    public function execute(array $data): Directory
    {
        $path = new Path($data['path']);

        if (!$this->repository->has($path)) {
            throw new EntityNotFoundException(sprintf('Directory \'%s\' is not exists or it\'s not readable', $path));
        }

        return $this->repository->readDirectory($path);
    }
}
