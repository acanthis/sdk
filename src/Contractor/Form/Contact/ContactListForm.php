<?php

namespace Eds\Contractor\Form\Contact;

use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\BooleanValidator;
use Nrg\Form\Validator\UuidValidator;

class ContactListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'creatorId',
        'name',
        'post',
        'phone',
        'email',
        'note',
        'isDefault',
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
                        'contractorId',
                        'creatorId'
                    ])

            )
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new BooleanValidator())
                    ->setFilterableFields(['isDefault'])
            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields([
                        'name',
                        'post',
                        'phone',
                        'email',
                        'note',
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
