<?php

namespace Eds\Contractor\Persistence\Filter;

use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;

class ContractorIdFilter extends Filter
{
    public function __construct(string $id)
    {
        parent::__construct();

        $this->addCondition(
            (new EqualCondition())
                ->setValue($id)
                ->setField('contractorId')
        );
    }
}
