<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;

class NotInConditionForm extends InConditionForm
{
    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_NOT_IN;
    }
}
