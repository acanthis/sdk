<?php

namespace Eds\Contractor\Form\BankAccount;

use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\BooleanValidator;
use Nrg\Form\Validator\UuidValidator;

class BankAccountListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'creatorId',
        'bankIdentificationCode',
        'correspondentAccount',
        'checkingAccount',
        'bankName',
        'bankAddress',
        'isDefault',
        'note',
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
                        'bankIdentificationCode',
                        'correspondentAccount',
                        'checkingAccount',
                        'bankName',
                        'bankAddress',
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
