<?php

namespace Nrg\Files\Persistence\Repository;

use Aws\S3\S3Client;
use DateTime;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Directory as FlysystemDirectory;
use League\Flysystem\FileExistsException;
use League\Flysystem\Filesystem;
use League\Flysystem\RootViolationException;
use Nrg\Files\Entity\Directory;
use Nrg\Files\Entity\File;
use Nrg\Files\Entity\Hyperlink;
use Nrg\Files\Entity\Storage;
use Nrg\Files\Entity\Storage\LocalStorage;
use Nrg\Files\Entity\Storage\ZipStorage;
use Nrg\Files\Persistence\Abstraction\FileRepositoryInterface;
use Nrg\Files\Value\Path;
use Nrg\Files\Value\Permissions;
use Nrg\Files\Value\Size;
use Nrg\Data\Dto\Filter;
use RuntimeException;

/**
 * @see https://github.com/thephpleague/flysystem
 */
class FlysystemFileRepository implements FileRepositoryInterface
{
    private $filesystem;

    public function __construct(
        string $uploadsPath,
        array $awsS3Config,
        string $bucket,
        string $storageType
    ) {
        switch ($storageType) {
            case 'aws s3':
                $adapter = new AwsS3Adapter(new S3Client($awsS3Config), $bucket);
                break;
            default:
                $adapter = new Local($uploadsPath);
        }

        $this->filesystem = new Filesystem($adapter);
    }

    public function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }

    public function readDirectory(Path $path): Directory
    {
        $this->mountStorage($path->getStorageId());

        return $this->createEntity($path->getStorageId(), $this->getMetadata($path));
    }

    public function createDirectory(Directory $directory): void
    {
        $this->mountStorage($directory->getPath()->getStorageId());

        $result = $this->filesystem->createDir((string)$directory->getPath());

        if (false === $result) {
            throw new RuntimeException(
                sprintf(
                    'Error occurred during creating the directory \'%s\'',
                    $directory->getPath()
                )
            );
        }
    }

    public function readFile(Path $path): File
    {
        $this->mountStorage($path->getStorageId());
        $contents = $this->filesystem->read((string)$path);

        return $this
            ->createEntity($path->getStorageId(), $this->getMetadata($path))
            ->setContents($contents);
    }

    public function createFile(File $file): void
    {
        $this->mountStorage($file->getPath()->getStorageId());

        $result = $this->filesystem->write((string)$file->getPath(), $file->getContents());

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during creating the file \'%s\'', $file->getPath())
            );
        }
    }

    public function updateFile(File $file): void
    {
        $this->mountStorage($file->getPath()->getStorageId());

        $result = $this->filesystem->update((string)$file->getPath(), $file->getContents());

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during updating the file \'%s\'', $file->getPath())
            );
        }
    }

    public function copyFile(Path $path, Path $newPath): void
    {
        $this
            ->mountStorage($path->getStorageId())
            ->mountStorage($newPath->getStorageId());

        try {
            $result = $this->filesystem->copy((string)$path, (string)$newPath);
        } catch (FileExistsException $e) {
            throw new RuntimeException($e->getMessage());
        }

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during copying the file \'%s\'', $path)
            );
        }
    }

    public function moveFile(Path $path, Path $newPath): void
    {
        $this
            ->mountStorage($path->getStorageId())
            ->mountStorage($newPath->getStorageId());

        $result = $this->filesystem->move((string)$path, (string)$newPath);

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during moving the file \'%s\'', $path)
            );
        }
    }

    public function writeStream(string $fileName, $stream): void
    {
        $result = $this->filesystem->writeStream($fileName, $stream);

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during uploading the file \'%s\'', $fileName)
            );
        }
    }

    public function deleteFile(string $filePath): void
    {
        $result = $this->filesystem->delete($filePath);

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during deleting the file \'%s\'', $filePath)
            );
        }
    }

    public function deleteDirectory(Path $path): void
    {
        $this->mountStorage($path->getStorageId());

        try {
            $result = $this->filesystem->deleteDir((string)$path);
        } catch (RootViolationException $e) {
            throw new RuntimeException($e->getMessage());
        }

        if (false === $result) {
            throw new RuntimeException(
                sprintf('Error occurred during deleting the directory \'%s\'', $path)
            );
        }
    }

    private function getMetadata(Path $path): array
    {
        if ($path->isRoot()) {
            return [
                'type' => File::TYPE_DIRECTORY,
                'path' => $path->getFilePath(),
                'children' => $this->filesystem->listContents((string)$path),
            ];
        }

        $file = $this->filesystem->get((string)$path);

        if ($file instanceof FlysystemDirectory) {
            return [
                'type' => File::TYPE_DIRECTORY,
                'path' => $path->getFilePath(),
                'children' => $file->getContents(),
            ];
        } else {
            return [
                    'path' => $path->getFilePath(),
                    'type' => $this->determineEntityType($file->getMetadata()),
                    'mimeType' => $file->getMimetype(),
                ] + $file->getMetadata();
        }
    }

    private function createEntity(string $storageId, array $file): File
    {
        switch ($file['type']) {
            case File::TYPE_DIRECTORY:
                $entity = new Directory(Path::create($storageId, $file['path'], true));

                if (isset($file['children'])) {
                    $entity->setChildren();
                    foreach ($file['children'] as $child) {
                        $child['type'] = $this->determineEntityType($child);
                        $entity->addChild($this->createEntity($storageId, $child));
                    }
                }
                break;
            case File::TYPE_HYPERLINK:
                $entity = new Hyperlink(Path::create($storageId, $file['path']));
                break;
            default:
                $entity = new File(Path::create($storageId, $file['path']));
        }

        if (isset($file['type'])) {
            $entity->setType($file['type']);
        }

        if (isset($file['mimeType'])) {
            $entity->setMimeType($file['mimeType']);
        }

        if (isset($file['size'])) {
            $entity->setSize(new Size((int)$file['size']));
        }

        if (isset($file['permissions'])) {
            $entity->setPermissions(new Permissions($file['permissions']));
        }

        if (isset($file['timestamp'])) {
            $entity->setLastModified(new DateTime(date('Y-m-d H:i:s', $file['timestamp'])));
        }

        return $entity;
    }

    private function determineEntityType($raw)
    {
        if ('dir' === $raw['type']) {
            return File::TYPE_DIRECTORY;
        }

        $extension = $raw['extension'] ?? pathinfo($raw['path'], PATHINFO_EXTENSION);

        if (in_array($extension, ['https', 'http'])) {
            return File::TYPE_HYPERLINK;
        }

        return File::TYPE_FILE;
    }

    private function mountStorage(string $storageId): FlysystemFileRepository
    {
        if (Storage::isTemporary($storageId)) {
            $storage = $this->tempStorageFactory->createById($storageId);
        } else {
            $storage = $this->storageRepository->findOne(
                (new Filter())
                    ->addCondition(
                        (new Equal())
                            ->setValue($storageId)
                            ->setField('id')
                    )
            );
        }

        /**
         * @var $storage LocalStorage|ZipStorage
         */
        switch ($storage->getType()) {
            case Storage::TYPE_LOCAL:
                $filesystem = new Filesystem(new Local($storage->getRoot()));
                break;
            case Storage::TYPE_ZIP:
                $filesystem = new Filesystem(new ZipArchiveAdapter($storage->getLocation()));
                break;
            case Storage::TYPE_FTP:
                $filesystem = new Filesystem(new Ftp($storage->getParams()));
                break;
            case Storage::TYPE_SFTP:
                $filesystem = new Filesystem(new SftpAdapter($storage->getParams()));
                break;
        }

        $this->filesystem->mountFilesystem($storage->getId(), $filesystem);

        return $this;
    }
}
