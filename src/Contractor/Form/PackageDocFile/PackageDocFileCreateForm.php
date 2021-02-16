<?php

namespace Eds\Contractor\Form\PackageDocFile;

use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Contractor\Abstraction\ConfigInterface;
use Eds\Contractor\Form\Element\PackageDoc\PackageDocFilesElement;
use Eds\Contractor\Form\Element\PackageDoc\PackageDocIdElement;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Nrg\Form\Form;

class PackageDocFileCreateForm extends Form
{
    private PackageDocRepositoryInterface $packageDocRepository;

    public function __construct(
        PackageDocRepositoryInterface $packageDocRepository,
        ConfigInterface $contractorConfig
    )
    {
        $this->packageDocRepository = $packageDocRepository;

        $this
            ->addElement((new PackageDocIdElement())
                ->isRequired()
            )
            ->addElement((new CreatorIdElement())
                ->isRequired()
            )
            ->addElement(
                (new PackageDocFilesElement(
                        $contractorConfig->getPackageDoc()->getAllowTypes(),
                        $contractorConfig->getPackageDoc()->getMaxFileSize()
                    )
                )
                ->isRequired()
            )
        ;
    }
}
