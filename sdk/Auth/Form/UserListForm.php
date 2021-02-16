<?php

namespace Nrg\Auth\Form;

use Nrg\Auth\Value\UserStatus;
use Nrg\Data\Form\EnumConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\GreaterOrEqualConditionForm;
use Nrg\Data\Form\InConditionForm;
use Nrg\Data\Form\LessOrEqualConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Data\Form\NotRangeConditionForm;
use Nrg\Data\Form\RangeConditionForm;
use Nrg\Form\Validator\ArrayValidator;
use Nrg\Form\Validator\EmailValidator;
use Nrg\Form\Validator\InArrayValidator;

class UserListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'email',
        'status',
        'createdAt',
        'updatedAt',
    ];

    public function __construct()
    {
        parent::__construct();

        $this
            ->setSortableFields(self::SORTABLE_FIELDS)
            ->addConditionForm(
                (new EnumConditionForm())
                    ->setEnum(UserStatus::ALLOWED_VALUES)
                    ->setFilterableFields(['status'])
            )
            ->addConditionForm(
                (new InConditionForm(
                    (new ArrayValidator())
                        ->addValidator(
                            (new InArrayValidator())
                                ->setHaystack(UserStatus::ALLOWED_VALUES)
                                ->setStrict(true)
                        )
                ))
                    ->setFilterableFields(['status'])
            )
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new EmailValidator())
                    ->setFilterableFields(['email'])
            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields(['email'])
            )
            ->addConditionForm(
                (new RangeConditionForm())
                    ->setFilterableFields(['createdAt', 'updatedAt'])
            )
            ->addConditionForm(
                (new NotRangeConditionForm())
                    ->setFilterableFields(['createdAt', 'updatedAt'])
            )
            ->addConditionForm(
                (new GreaterOrEqualConditionForm())
                    ->setFilterableFields(['createdAt', 'updatedAt'])
            )
            ->addConditionForm(
                (new LessOrEqualConditionForm())
                    ->setFilterableFields(['createdAt', 'updatedAt'])
            );
    }
}
