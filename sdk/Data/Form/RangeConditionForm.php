<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;
use Nrg\Form\Element;
use Nrg\Form\Filter\TrimFilter;
use Nrg\Form\Validator\ScalarValidator;

class RangeConditionForm extends ConditionForm
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addElement(
                (new Element())
                    ->setName('min')

                    ->addFilter(new TrimFilter())
                    ->addValidator(new ScalarValidator())
            )
            ->addElement(
                (new Element())
                    ->setName('max')

                    ->addFilter(new TrimFilter())
                    ->addValidator(new ScalarValidator())
            )
        ;
    }

    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_RANGE;
    }
}
