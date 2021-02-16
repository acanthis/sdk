<?php

namespace Nrg\Files\UseCase\Directory;

use DateTime;
use Nrg\Files\Entity\Directory;
use Nrg\Files\Entity\File;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Files\Value\Permissions;
use Nrg\Files\Value\Size;

/**
 * Class CreateDirectory.
 *
 * Service to create directory.
 */
class CreateDirectory
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * @var int
     */
    private $defaultPermissions = 0755;

    /**
     * CreateDirectory constructor.
     *
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Creates an empty directory.
     *
     * @example for the data:
     * [
     *  'path' => '/folder1/folder2', // required
     *  'permissions' => 0755,        // optional
     * ]
     *
     * @param array $data
     *
     * @return Directory
     */
    public function execute(array $data): Directory
    {
        $directory = new Directory(new Path($data['path'], true));

        $directory
            ->setChildren()
            ->setType(File::TYPE_DIRECTORY)
            ->setSize(new Size(0))
            ->setPermissions(new Permissions($data['permissions'] ?? $this->defaultPermissions))
            ->setLastModified(new DateTime());

        $this->repository->createDirectory($directory);

        return $directory;
    }
}
