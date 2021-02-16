<?php

namespace Nrg\Data\Form;

use Nrg\Data\Dto\Filtering;

class NotLikeConditionForm extends LikeConditionForm
{
    protected function getConditionName(): string
    {
        return Filtering::CONDITION_NAME_NOT_LIKE;
    }
}
