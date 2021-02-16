<?php

namespace Eds\Contractor\UseCase\PackageDocFile;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Nrg\Files\Persistence\Abstraction\FileRepositoryInterface;

class PackageDocFileDelete
{
    private PackageDocFileRepositoryInterface $packageDocFileRepository;
    private FileRepositoryInterface $fileRepository;

    public function __construct(PackageDocFileRepositoryInterface $packageDocFileRepository, FileRepositoryInterface $fileRepository)
    {
        $this->packageDocFileRepository = $packageDocFileRepository;
        $this->fileRepository = $fileRepository;
    }

    public function execute(array $data): int
    {
        $filter = new IdFilter($data['id']);
        $contractorPackageDocFile = $this->packageDocFileRepository->findOne($filter);

        if ($this->fileRepository->has($contractorPackageDocFile->getFilePath())) {
            $this->fileRepository->deleteFile($contractorPackageDocFile->getFilePath());
        }

        return $this->packageDocFileRepository->delete($filter);
    }
}
