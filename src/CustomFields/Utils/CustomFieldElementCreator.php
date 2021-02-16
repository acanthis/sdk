<?php

namespace Eds\CustomFields\Utils;

use Eds\Contractor\Form\Validator\ContractorExistValidator;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldBooleanElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldClientListElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldDateElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldFloatElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldIntegerElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldNumericElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldSystemListElement;
use Eds\CustomFields\Form\Element\Attribute\CustomFieldTextElement;
use Eds\Organization\Form\Validator\OrganizationExistValidator;
use Eds\CustomFields\Entity\BaseCustomField;
use Eds\CustomFields\Value\CustomFieldType;
use OutOfRangeException;

class CustomFieldElementCreator
{
    private ContractorExistValidator $contractorExistValidator;
    private OrganizationExistValidator $organizationExistValidator;

    public function __construct(ContractorExistValidator $contractorExistValidator, OrganizationExistValidator $organizationExistValidator)
    {
        $this->contractorExistValidator = $contractorExistValidator;
        $this->organizationExistValidator = $organizationExistValidator;
    }

    public function create(BaseCustomField $customField)
    {
        $attributes = json_decode($customField->getAttributes(), true);

        switch ($customField->getType()) {
            case CustomFieldType::TYPE_BOOLEAN:
                return new CustomFieldBooleanElement();
            case CustomFieldType::TYPE_INTEGER:
                return new CustomFieldIntegerElement($attributes);
            case CustomFieldType::TYPE_FLOAT:
                return new CustomFieldFloatElement($attributes);
            case CustomFieldType::TYPE_NUMERIC:
                return new CustomFieldNumericElement($attributes);
            case CustomFieldType::TYPE_TEXT:
                return new CustomFieldTextElement($attributes);
            case CustomFieldType::TYPE_DATE:
                return new CustomFieldDateElement();
            case CustomFieldType::TYPE_CLIENT_LIST:
                return new CustomFieldClientListElement();
            case CustomFieldType::TYPE_SYSTEM_LIST:
                // TODO: Плата за DI
                return new CustomFieldSystemListElement(
                    $this->contractorExistValidator,
                    $this->organizationExistValidator,
                    $attributes['relationName']
                );
            default:
                throw new OutOfRangeException('Unknown type of custom field');
        }
    }
}
