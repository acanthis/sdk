<?php

namespace Eds\Contractor\UseCase\PackageDoc;

use DateTime;
use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Dto\UpdateRawDataInput;
use Eds\Contractor\Entity\ContractorPackageDoc;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Contractor\Persistence\Factory\PackageDocFactory;

class PackageDocUpdate
{
    private PackageDocRepositoryInterface $packageDocRepository;
    private PackageDocFactory $packageDocFactory;

    public function __construct(
        PackageDocRepositoryInterface $packageDocRepository,
        PackageDocFactory $packageDocFactory
    ) {
        $this->packageDocRepository = $packageDocRepository;
        $this->packageDocFactory = $packageDocFactory;
    }

    public function execute(UpdateRawDataInput $input): ContractorPackageDoc
    {
        $data = $input->toArray();
        $contractorPackageDoc = $this->packageDocRepository->findOne(new IdFilter($data['id']));

        if ($input->hasChanged($this->packageDocFactory->arrayToCreate($contractorPackageDoc))) {
            $data['updatedAt'] = new DateTime();
            $contractorPackageDoc->populateProps($data);
            $this->packageDocRepository->update($contractorPackageDoc, array_keys($data));
        }

        return $contractorPackageDoc;
    }
}
