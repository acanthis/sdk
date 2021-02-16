<?php

namespace Eds\Contractor\Form\Status;

use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\UuidValidator;

class StatusListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'creatorId',
        'name',
        'color',
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
                        'creatorId',
                        'color',
                    ])

            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields([
                        'name',
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
