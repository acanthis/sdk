<?php

namespace Eds\Contractor\Form\Contractor;

use Eds\Contractor\Value\ContractorType;
use Nrg\Data\Form\RangeConditionForm;
use Nrg\Data\Form\EqualConditionForm;
use Nrg\Data\Form\EnumConditionForm;
use Nrg\Data\Form\LikeConditionForm;
use Nrg\Data\Form\ListForm;
use Nrg\Form\Validator\BooleanValidator;
use Nrg\Form\Validator\UuidValidator;

class ContractorListForm extends ListForm
{
    private const SORTABLE_FIELDS = [
        'id',
        'clientId',
        'statusId',
        'creatorId',
        'type',
        'shortName',
        'fullName',
        'code',
        'inn',
        'kpp',
        'ogrn',
        'ogrnIp',
        'okpo',
        'numberOfCertificate',
        'dateOfCertificate',
        'phone',
        'phoneMobile',
        'fax',
        'email',
        'url',
        'legalAddress',
        'actualAddress',
        'registrationAddress',
        'note',
        'isArchive',
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
                        'statusId',
                        'creatorId'
                    ]
                )
            )
            ->addConditionForm(
                (new EqualConditionForm())
                    ->addValueValidator(new BooleanValidator())
                    ->setFilterableFields(['isArchive'])
            )
            ->addConditionForm(
                (new EnumConditionForm())
                    ->setFilterableFields(['type'])
                    ->setEnum(ContractorType::CONTRACTOR_TYPE_MAP)
            )
            ->addConditionForm(
                (new LikeConditionForm())
                    ->setFilterableFields([
                        'shortName',
                        'fullName',
                        'code',
                        'inn',
                        'kpp',
                        'ogrn',
                        'ogrnIp',
                        'okpo',
                        'numberOfCertificate',
                        'phone',
                        'phoneMobile',
                        'fax',
                        'email',
                        'url',
                        'legalAddress',
                        'actualAddress',
                        'registrationAddress',
                        'note',
                    ]
                )
            )
            ->addConditionForm(
                (new RangeConditionForm())
                    ->setFilterableFields([
                        'createdAt',
                        'updatedAt',
                        'dateOfCertificate',
                    ]
                )
            )
        ;
    }
}
