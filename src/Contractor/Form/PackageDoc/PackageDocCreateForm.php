<?php

namespace Eds\Contractor\Form\PackageDoc;

use Eds\Common\Form\Element\CreatorIdElement;
use Eds\Contractor\Form\Element\Contractor\ContractorIdElement;
use Eds\Contractor\Form\Element\PackageDoc\PackageDocExpireElement;
use Eds\Contractor\Form\Element\PackageDoc\PackageDocNameElement;
use Eds\Contractor\Form\Validator\ContractorExistValidator;
use Eds\Contractor\Form\Validator\UniquePackageDocNameValidator;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Nrg\Form\Form;

class PackageDocCreateForm extends Form
{
    public function __construct(
        PackageDocRepositoryInterface $packageDocRepository,
        ContractorRepositoryInterface $contractorRepository
    )
    {
        $this
            ->addElement((new ContractorIdElement())
                ->isRequired()
                ->addValidator(new ContractorExistValidator($contractorRepository))
            )
            ->addElement((new CreatorIdElement())
                ->isRequired()
            )
            ->addElement((new PackageDocNameElement())
                ->isRequired()
                ->addValidator(new UniquePackageDocNameValidator($packageDocRepository))
            )
            ->addElement((new PackageDocExpireElement())
                ->isRequired()
            )
        ;
    }
}
