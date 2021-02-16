<?php

namespace Eds\Contractor\Form\Validator;

use Eds\Common\Persistence\Filter\NotIdFilter;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class UniqueContractorInnValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_innMustBeUnique';

    private ?string $exceptId = null;
    private ContractorRepositoryInterface $contractorRepository;

    public function __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function isValid(ElementInterface $element): bool
    {
        $this->setErrors(new Message(self::ERROR, ['inn' => $element->getValue()]));

        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($element->getValue())
                    ->setField('inn')
            )
        ;

        if (null !== $this->exceptId) {
            $filter->addFilter((new NotIdFilter($this->exceptId)));
        }

        return !$this->contractorRepository->exists($filter);
    }

    public function setExceptId(string $exceptId): UniqueContractorInnValidator
    {
        $this->exceptId = $exceptId;

        return $this;
    }
}
