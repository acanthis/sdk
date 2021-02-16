<?php

namespace Eds\Common\Persistence\Filter;

use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class CustomFieldUpdateFilter extends Filter
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addCondition(
                (new EqualCondition())
                    ->setField('isShowOnUpdate')
                    ->setValue(1)
                )
            ->addCondition(
                (new EqualCondition())
                    ->setField('isMarkOnDelete')
                    ->setValue(0)
                )
        ;
    }
}
