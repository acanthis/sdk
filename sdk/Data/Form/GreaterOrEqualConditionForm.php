<?php

namespace Nrg\Data\Form;

class GreaterOrEqualConditionForm extends EqualConditionForm
{
    protected function getConditionName(): string
    {
        return 'greaterOrEqual';
    }
}
