<?php

namespace Eds\Common\Persistence\Filter;

use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class CustomFieldCreateFilter extends Filter
{
    public function __construct()
    {
        parent::__construct();

        $this
            ->addCondition(
                (new EqualCondition())
                    ->setField('isShowOnCreate')
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
