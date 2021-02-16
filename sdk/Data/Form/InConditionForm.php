<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;
use Nrg\Form\Element;
use Nrg\Form\Validator\ArrayValidator;

class InConditionForm extends ConditionForm
{
    private const LITERAL_PROPERTY_LIST = 'list';

    public function __construct(ArrayValidator $arrayElementValidator)
    {
        parent::__construct();

        $this
            ->addElement(
                (new Element())
                    ->setName(self::LITERAL_PROPERTY_LIST)
                    ->isRequired()
                    ->addValidator($arrayElementValidator)
            )
        ;
    }

    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_IN;
    }
}
