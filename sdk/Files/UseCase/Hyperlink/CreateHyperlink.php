<?php

namespace Nrg\Files\UseCase\Hyperlink;

use DateTime;
use Nrg\Files\Entity\Hyperlink;
use Nrg\Files\Exception\FileExistsException;
use Nrg\Files\Persistence\Abstraction\FileRepository;
use Nrg\Files\Value\Path;
use Nrg\Files\Value\Permissions;
use Nrg\Files\Value\Size;
use Nrg\Http\Value\Url;

/**
 * Class CreateHyperlink.
 *
 * Use case to create a new hyperlink.
 */
class CreateHyperlink
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
     * Creates a new hyperlink.
     *
     * @example for the data:
     * [
     *  'path' => '/folder1/hyperlink.txt',  // required
     *  'url' => 'https://somedomain.com'  // required
     *  'permissions' => 0644,          // optional
     * ]
     *
     * @param array $data
     *
     * @return Hyperlink
     */
    public function execute(array $data): Hyperlink
    {
        $url = new Url($data['url']);
        $path = new Path($data['path']);

        /**
         * @var $hyperlink Hyperlink
         */
        $hyperlink = (new Hyperlink($path))
            ->setUrl($url)
            ->setSize(new Size(mb_strlen((string)$url, '8bit')))
            ->setPermissions(new Permissions($data['permissions'] ?? $this->defaultPermissions))
            ->setLastModified(new DateTime());

        $this->repository->createFile($hyperlink);

        return $hyperlink;
    }
}
