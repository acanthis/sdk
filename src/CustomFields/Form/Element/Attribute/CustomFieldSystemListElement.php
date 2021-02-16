<?php

namespace Eds\CustomFields\Form\Element\Attribute;

use Eds\Contractor\Form\Validator\ContractorExistValidator;
use Eds\CustomFields\Form\Element\Type\SystemDataList\RelationNameElement;
use Eds\Organization\Form\Validator\OrganizationExistValidator;
use Nrg\Form\Element;
use Nrg\Form\Validator\UuidValidator;

class CustomFieldSystemListElement extends Element
{
    public function __construct(
        ContractorExistValidator $contractorExistValidator,
        OrganizationExistValidator $organizationExistValidator,
        string $relationName
    )
    {
        $this->addValidator(new UuidValidator());

        switch ($relationName) {
            case RelationNameElement::CONTRACTOR_RELATION_NAME:
                $this->addValidator($contractorExistValidator);
                break;
            case RelationNameElement::ORGANIZATION_RELATION_NAME:
                $this->addValidator($organizationExistValidator);
                break;
        }
    }
}