<?php

namespace Nrg\Files\UseCase\File;

use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;

/**
 * Class IsUniquePath
 */
class IsUniquePath
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
     * @param array $data
     *
     * @return bool
     */
    public function execute(array $data): bool
    {
        return !$this->repository->has(new Path($data['path']));
    }
}