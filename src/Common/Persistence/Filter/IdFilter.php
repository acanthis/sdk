<?php

namespace Eds\Common\Persistence\Filter;

use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class IdFilter extends Filter
{
    public function __construct(string $id, string $alias = '')
    {
        parent::__construct();

        $this->addCondition((new EqualCondition())
            ->setValue($id)
            ->setField($alias ? "{$alias}.id" : 'id')
        );
    }
}
