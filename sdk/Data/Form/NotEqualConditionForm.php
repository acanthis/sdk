<?php

namespace Nrg\Data\Form;

class NotEqualConditionForm extends EqualConditionForm
{
    protected function getConditionName(): string
    {
        return 'notEqual';
    }
}
