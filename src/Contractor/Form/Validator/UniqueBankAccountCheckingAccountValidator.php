<?php

namespace Eds\Contractor\Form\Validator;

use Eds\Common\Persistence\Filter\NotIdFilter;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class UniqueBankAccountCheckingAccountValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_checkingAccountMustBeUnique';

    private ?string $exceptId = null;
    private BankAccountRepositoryInterface $bankAccountRepository;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function isValid(ElementInterface $element): bool
    {
        $this->setErrors(new Message(self::ERROR, ['checkingAccount' => $element->getValue()]));

        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($element->getValue())
                    ->setField('checkingAccount')
            )
            ->addCondition(
                 (new EqualCondition())
                     ->setValue($element->getParent()->getElement('contractorId')->getValue())
                     ->setField('contractorId')
            )
        ;

        if (null !== $this->exceptId) {
            $filter->addFilter((new NotIdFilter($this->exceptId)));
        }

        return !$this->bankAccountRepository->exists($filter);
    }

    public function setExceptId(string $exceptId): UniqueBankAccountCheckingAccountValidator
    {
        $this->exceptId = $exceptId;

        return $this;
    }
}
