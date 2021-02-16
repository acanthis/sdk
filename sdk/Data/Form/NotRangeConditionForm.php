<?php

namespace Nrg\Data\Form;

class NotRangeConditionForm extends RangeConditionForm
{
    protected function getConditionName(): string
    {
        return 'outRange';
    }
}
