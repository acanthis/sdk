<?php

namespace Eds\Common\Persistence\Filter;

use Nrg\Data\Condition\NotEqualCondition;
use Nrg\Data\Dto\Filter;

class NotIdFilter extends Filter
{
    public function __construct(string $id)
    {
        parent::__construct();

        $this->addCondition(
            (new NotEqualCondition())
                ->setValue($id)
                ->setField('id')
        );
    }
}
