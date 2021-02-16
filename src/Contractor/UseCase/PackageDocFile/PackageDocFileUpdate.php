<?php

namespace Eds\Contractor\UseCase\PackageDocFile;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorPackageDocFile;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFileFactory;

class PackageDocFileUpdate
{
    private PackageDocFileRepositoryInterface $packageDocFileRepository;
    private PackageDocFileFactory $packageDocFileFactory;

    public function __construct(
        PackageDocFileRepositoryInterface $packageDocFileRepository,
        PackageDocFileFactory $packageDocFileFactory
    ) {
        $this->packageDocFileRepository = $packageDocFileRepository;
        $this->packageDocFileFactory = $packageDocFileFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorPackageDocFile
    {
        $data = $input->toArray();
        $contractorPackageDocFile = $this->packageDocFileRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->packageDocFileFactory->arrayToCreate($contractorPackageDocFile))) {
            $fileParts = pathinfo($contractorPackageDocFile->getOriginalName());
            $data['updatedAt'] = new DateTime();
            $data['originalName'] = $data['originalName'].'.'.$fileParts['extension'];
            $contractorPackageDocFile->populateProps($data);
            $this->packageDocFileRepository->update($contractorPackageDocFile, array_keys($data));
        }

        return $contractorPackageDocFile;
    }
}
