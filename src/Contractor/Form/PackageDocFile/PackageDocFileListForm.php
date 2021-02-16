<?php

namespace Eds\Contractor\Form\PackageDocFile;

use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Data\Form\RangeConditionForm;
use Nrg\Form\Validator\UuidValidator;

class PackageDocFileListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'creatorId',
        'originalName',
        'size',
        'mimeType',
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
                        'packageDocId',
                        'creatorId',
                        'mimeType',
                    ])

            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields([
                        'originalName',
                    ]
                )
            )
            ->addConditionForm(
                (new RangeConditionForm())
                    ->setFilterableFields([
                            'size',
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
