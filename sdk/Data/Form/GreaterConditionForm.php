<?php

namespace Nrg\Data\Form;

class GreaterConditionForm extends EqualConditionForm
{
    protected function getConditionName(): string
    {
        return 'greater';
    }
}
