<?php

namespace Nrg\Data\Form;

class LessOrEqualConditionForm extends EqualConditionForm
{
    protected function getConditionName(): string
    {
        return 'lessOrEqual';
    }
}
