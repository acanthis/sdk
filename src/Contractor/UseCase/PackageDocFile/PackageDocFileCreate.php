<?php

namespace Eds\Contractor\UseCase\PackageDocFile;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Common\Utils\FileHashGenerator;
use Eds\Contractor\Entity\ContractorPackageDoc;
use Eds\Contractor\Entity\ContractorPackageDocFile;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFactory;
use Eds\Contractor\Persistence\Factory\PackageDocFileFactory;
use Eds\Contractor\Utils\FilePathCreator;
use Nrg\Doctrine\Abstraction\Connection;
use Nrg\Files\Persistence\Abstraction\FileRepositoryInterface;
use Nrg\Http\Value\UploadedFile;
use Nrg\Utility\Abstraction\UuidGenerator;
use RuntimeException;

class PackageDocFileCreate
{
    private PackageDocRepositoryInterface $packageDocRepository;
    private PackageDocFileRepositoryInterface $packageDocFileRepository;
    private FileRepositoryInterface $fileRepository;
    private PackageDocFactory $packageDocFactory;
    private PackageDocFileFactory $packageDocFileFactory;
    private UuidGenerator $uuid;
    private FileHashGenerator $fileHashGenerator;
    private FilePathCreator $filePathCreator;
    private Connection $connection;

    public function __construct(
        PackageDocRepositoryInterface $packageDocRepository,
        PackageDocFileRepositoryInterface $packageDocFileRepository,
        FileRepositoryInterface $fileRepository,
        PackageDocFactory $packageDocFactory,
        PackageDocFileFactory $packageDocFileFactory,
        UuidGenerator $uuid,
        FileHashGenerator $fileHashGenerator,
        FilePathCreator $filePathCreator,
        Connection $connection
    ) {
        $this->packageDocRepository = $packageDocRepository;
        $this->packageDocFileRepository = $packageDocFileRepository;
        $this->fileRepository = $fileRepository;
        $this->packageDocFactory = $packageDocFactory;
        $this->packageDocFileFactory = $packageDocFileFactory;
        $this->uuid = $uuid;
        $this->fileHashGenerator = $fileHashGenerator;
        $this->filePathCreator = $filePathCreator;
        $this->connection = $connection;
    }

    public function execute(array $data): ContractorPackageDoc
    {
        $data['id'] = $this->uuid->generateV4();
        $packageDoc = $this->packageDocRepository->findOne(new IdFilter($data['packageDocId']));

        try {
            $this->connection->beginTransaction();

            /** @var UploadedFile $file */
            foreach ($data['files'] as $file) {
                $filePath = $this->filePathCreator->cretePackageDocFilePath(
                    $file->getTmpName(),
                    $file->getExtension(),
                    $packageDoc->getContractor(),
                    $packageDoc->getId()
                );

                // TODO проверка в бд на уникальность ['package_doc_id', 'file_path'], ['unique' => true])?
                if ($this->fileRepository->has($filePath)) {
                    continue;
                }

                $stream = fopen($file->getTmpName(), 'r+');
                $this->fileRepository->writeStream($filePath, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                $packageDocFile = new ContractorPackageDocFile(
                    $this->uuid->generateV4(),
                    $packageDoc->getId(),
                    $data['creatorId'],
                    $file->getName(),
                    $filePath,
                    $file->getSize(),
                    $file->getType(),
                    new DateTime()
                );

                $this->packageDocFileRepository->create($packageDocFile);
            }

            $this->connection->commit();
        } catch (\Throwable $throwable) {
            $this->connection->rollBack();

            throw new RuntimeException($throwable->getMessage());
        }

        return $packageDoc;
    }
}
