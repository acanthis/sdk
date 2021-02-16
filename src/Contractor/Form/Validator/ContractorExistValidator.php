<?php

namespace Eds\Contractor\Form\Validator;

use Eds\Common\Persistence\Filter\IdFilter;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class ContractorExistValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_contractorNotFound';

    private ContractorRepositoryInterface $contractorRepository;

    public function  __construct(ContractorRepositoryInterface $contractorRepository)
    {
        $this->contractorRepository = $contractorRepository;
    }

    public function isValid(ElementInterface $element): bool
    {
        $this->setErrors(new Message(self::ERROR, ['contractorId' => $element->getValue()]));

        return $this->contractorRepository->exists(new IdFilter($element->getValue()));
    }
}
