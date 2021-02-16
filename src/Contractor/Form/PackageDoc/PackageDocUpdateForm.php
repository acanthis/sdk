<?php

namespace Eds\Contractor\Form\PackageDoc;

use Eds\Contractor\Form\Element\PackageDoc\PackageDocExpireElement;
use Eds\Contractor\Form\Element\PackageDoc\PackageDocNameElement;
use Eds\Contractor\Form\Validator\UniquePackageDocNameValidator;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Form;

class PackageDocUpdateForm extends Form
{
    private UniquePackageDocNameValidator $uniquePackageDocNameValidator;

    public function __construct(UniquePackageDocNameValidator $uniquePackageDocNameValidator)
    {
        $this->uniquePackageDocNameValidator = $uniquePackageDocNameValidator;
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(
                (new PackageDocNameElement())
                    ->isRequired()
            )
            ->addElement(new PackageDocExpireElement())
        ;
    }

    public function setValue($data): Form
    {
        parent::setValue($data);
        $idElement = $this->getElement('id');

        if ($idElement->isValid()) {
            $this->getElement('name')
                ->addValidator(
                    $this->uniquePackageDocNameValidator->setExceptId(
                        $idElement->getValue()
                    )
                )
            ;
        }

        return $this;
    }
}
