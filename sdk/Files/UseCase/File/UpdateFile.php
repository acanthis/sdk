<?php

namespace Nrg\Files\UseCase\File;

use DateTime;
use Nrg\Files\Entity\File;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Files\Value\Size;
use Nrg\Data\Exception\EntityNotFoundException;

/**
 * Class UpdateFile.
 *
 * Use case to create a new file.
 */
class UpdateFile
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * @var int
     */
    private $defaultPermissions = 0644;

    /**
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Updates a new file.
     *
     * @example for the data:
     * [
     *  'path' => '/folder1/file.txt',  // required
     *  'contents' => 'Some data here'  // required
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
            throw new EntityNotFoundException(sprintf('File \'%s\' not found', $path));
        }

        $file = $this->repository->readFile($path);

        $file
            ->setSize(new Size(isset($data['contents']) ? mb_strlen($data['contents'], '8bit') : 0))
            ->setLastModified(new DateTime())
            ->setContents($data['contents']);

        $this->repository->updateFile($file);

        return $file;
    }
}
