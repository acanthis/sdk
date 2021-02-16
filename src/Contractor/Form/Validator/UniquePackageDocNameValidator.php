<?php

namespace Eds\Contractor\Form\Validator;

use Eds\Common\Persistence\Filter\NotIdFilter;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Form\Abstraction\ElementInterface;
use Nrg\Form\Abstraction\ValidatorInterface;
use Nrg\Form\Helper\ErrorsTrait;
use Nrg\I18n\Value\Message;

class UniquePackageDocNameValidator implements ValidatorInterface
{
    use ErrorsTrait;

    public const ERROR = 'contractor_validation_packageDocNameMustBeUnique';

    private PackageDocRepositoryInterface $packageDocRepository;
    private ?string $exceptId = null;

    public function __construct(PackageDocRepositoryInterface $packageDocRepository)
    {
        $this->packageDocRepository = $packageDocRepository;
    }

    public function isValid(ElementInterface $element): bool
    {
        $this->setErrors(new Message(self::ERROR, ['name' => $element->getValue()]));

        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($element->getValue())
                    ->setField('name')
            )
        ;

        if (null !== $this->exceptId) {
            $filter->addFilter((new NotIdFilter($this->exceptId)));
        }

        return !$this->packageDocRepository->exists($filter);
    }

    public function setExceptId(string $exceptId): UniquePackageDocNameValidator
    {
        $this->exceptId = $exceptId;

        return $this;
    }
}
