<?php

namespace Eds\Contractor\Form\PackageDoc;

use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\UuidValidator;

class PackageDocListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'creatorId',
        'name',
        'expire',
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
                        'creatorId',
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
                        'expire',
                        'createdAt',
                        'updatedAt',
                    ]
                )
            )
        ;
    }
}
