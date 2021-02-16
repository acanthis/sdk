<?php

namespace Eds\CustomFields\Form\Element\Type\SystemDataList;

use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\InArrayValidator;

class RelationNameElement extends Element
{
    // TODO: стоит перенести в другое место?
    public const CONTRACTOR_RELATION_NAME = 'contractor';
    public const ORGANIZATION_RELATION_NAME = 'organization';

    public const MAP_RELATION_NAMES = [
        self::CONTRACTOR_RELATION_NAME,
        self::ORGANIZATION_RELATION_NAME,
    ];

    public function __construct()
    {
        $this
            ->setName('relationName')
            ->addFilter(new TrimFilter())
            ->addValidator(
                (new InArrayValidator())
                    ->setHaystack(self::MAP_RELATION_NAMES)
            )
        ;
    }
}
