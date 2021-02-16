<?php

namespace Nrg\Data\Form;

class LessConditionForm extends EqualConditionForm
{
    protected function getConditionName(): string
    {
        return 'less';
    }
}
