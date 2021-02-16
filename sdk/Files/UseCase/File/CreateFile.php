<?php

namespace Nrg\Files\UseCase\File;

use DateTime;
use Nrg\Files\Entity\File;
use Nrg\Files\Exception\FileExistsException;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Files\Value\Permissions;
use Nrg\Files\Value\Size;

/**
 * Class CreateFile.
 *
 * Use case to create a new file.
 */
class CreateFile
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
     * Creates a new file.
     *
     * @example for the data:
     * [
     *  'path' => '/folder1/file.txt',  // required
     *  'contents' => 'Some data here'  // optional
     *  'permissions' => 0644,          // optional
     * ]
     *
     * @param array $data
     *
     * @return File
     */
    public function execute(array $data): File
    {
        $path = new Path($data['path']);

        if ($this->repository->has($path)) {
            throw new FileExistsException(sprintf('File \'%s\' is already exists', $path));
        }

        $file = (new File($path))
            ->setPermissions(new Permissions($data['permissions'] ?? $this->defaultPermissions))
            ->setLastModified(new DateTime());

        if (isset($data['contents'])) {
            $file
                ->setContents($data['contents'])
                ->setSize(new Size(mb_strlen($data['contents'], '8bit')));
        } else {
            $file->setSize(new Size(0));
        }

        $this->repository->createFile($file);

        return $file;
    }
}
