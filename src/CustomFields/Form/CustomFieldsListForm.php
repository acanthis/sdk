<?php

namespace Eds\CustomFields\Form;

use Eds\CustomFields\Value\CustomFieldType;
use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\EnumConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\BooleanValidator;
use Nrg\Form\Validator\UuidValidator;

class CustomFieldsListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'clientId',
        'creatorId',
        'name',
        'type',
        'description',
        'isRequiredOnCreate',
        'isRequiredOnUpdate',
        'isShowOnCreate',
        'isShowOnUpdate',
        'isUnique',
        'isUseInFilter',
        'isMarkOnDelete',
        'createdAt',
        'updatedAt',
    ];

    public function __construct()
    {
        parent::__construct();
        $this
            ->setSortableFields(self::SORTABLE_FIELDS)
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new UuidValidator())
                    ->setFilterableFields([
                        'id',
                        'clientId',
                        'creatorId'
                    ]
                )
            )
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new BooleanValidator())
                    ->setFilterableFields(['isRequiredOnCreate'])
                    ->setFilterableFields(['isRequiredOnUpdate'])
                    ->setFilterableFields(['isShowOnCreate'])
                    ->setFilterableFields(['isShowOnUpdate'])
                    ->setFilterableFields(['isUnique'])
                    ->setFilterableFields(['isUseInFilter'])
                    ->setFilterableFields(['isMarkOnDelete'])
            )
            ->addConditionForm(
                (new EnumConditionForm())
                    ->setFilterableFields(['type'])
                    ->setEnum(CustomFieldType::CUSTOM_FIELD_TYPE_LIST)
            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields([
                        'name',
                        'description',
                    ]
                )
            )
            ->addConditionForm(
                (new RangeConditionForm())
                    ->setFilterableFields([
                        'createdAt',
                        'updatedAt',
                    ]
                )
            )
        ;
    }
}
