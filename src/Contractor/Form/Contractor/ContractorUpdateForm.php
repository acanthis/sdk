<?php

namespace Eds\Contractor\Form\Contractor;

use Eds\Common\Form\Element\EmailElement;
use Eds\Common\Form\Element\NoteElement;
use Eds\Common\Form\Element\PhoneElement;
use Eds\Common\Form\Element\PhoneMobileElement;
use Eds\Common\Persistence\Filter\CustomFieldUpdateFilter;
use Eds\Contractor\Entity\ContractorCustomField;
use Eds\Contractor\Form\Element\Contractor\ContractorActualAddressElement;
use Eds\Contractor\Form\Element\Contractor\ContractorCodeElement;
use Eds\Contractor\Form\Element\Contractor\ContractorDateOfCertificateElement;
use Eds\Contractor\Form\Element\Contractor\ContractorFaxElement;
use Eds\Contractor\Form\Element\Contractor\ContractorFullNameElement;
use Eds\Contractor\Form\Element\Contractor\ContractorInnElement;
use Eds\Contractor\Form\Element\Contractor\ContractorIsArchiveElement;
use Eds\Contractor\Form\Element\Contractor\ContractorKppElement;
use Eds\Contractor\Form\Element\Contractor\ContractorLegalAddressElement;
use Eds\Contractor\Form\Element\Contractor\ContractorNumberOfCertificateElement;
use Eds\Contractor\Form\Element\Contractor\ContractorOgrnElement;
use Eds\Contractor\Form\Element\Contractor\ContractorOgrnIpElement;
use Eds\Contractor\Form\Element\Contractor\ContractorOkpoElement;
use Eds\Contractor\Form\Element\Contractor\ContractorRegistrationAddressElement;
use Eds\Contractor\Form\Element\Contractor\ContractorShortNameElement;
use Eds\Contractor\Form\Element\Contractor\ContractorStatusIdElement;
use Eds\Contractor\Form\Element\Contractor\ContractorTypeElement;
use Eds\Contractor\Form\Element\Contractor\ContractorUrlElement;
use Eds\Contractor\Form\Validator\UniqueContractorInnValidator;
use Eds\Contractor\Persistence\Repository\PgSqlCustomFieldRepository;
use Eds\CustomFields\Utils\CustomFieldElementCreator;
use Nrg\Form\Element\UuidRequiredElement;
use Nrg\Form\Filter\DefaultNullFilter;
use Nrg\Form\Form;
use Nrg\Utility\Abstraction\UuidGenerator;

class ContractorUpdateForm extends Form
{
    private UniqueContractorInnValidator $uniqueContractorInnValidator;
    private PgSqlCustomFieldRepository $customFieldRepository;
    private CustomFieldElementCreator $customFieldElementCreator;
    private UuidGenerator $uuidGenerator;

    public function __construct(
        UniqueContractorInnValidator $uniqueContractorInnValidator,
        PgSqlCustomFieldRepository $customFieldRepository,
        CustomFieldElementCreator $customFieldElementCreator,
        UuidGenerator $uuidGenerator
    )
    {
        $this->uniqueContractorInnValidator = $uniqueContractorInnValidator;
        $this->customFieldRepository = $customFieldRepository;
        $this->customFieldElementCreator = $customFieldElementCreator;
        $this->uuidGenerator = $uuidGenerator;
        $this
            ->addElement(new UuidRequiredElement())
            ->addElement(new ContractorInnElement())
            ->addElement(new ContractorTypeElement())
            ->addElement(new ContractorShortNameElement())
            ->addElement(new ContractorStatusIdElement())
            ->addElement(new ContractorFullNameElement())
            ->addElement(new ContractorCodeElement())
            ->addElement(new ContractorKppElement())
            ->addElement(new ContractorOgrnElement())
            ->addElement(new ContractorOgrnIpElement())
            ->addElement(new ContractorOkpoElement())
            ->addElement(new ContractorNumberOfCertificateElement())
            ->addElement(new ContractorDateOfCertificateElement())
            ->addElement(new PhoneElement())
            ->addElement(new PhoneMobileElement())
            ->addElement(new ContractorFaxElement())
            ->addElement(new EmailElement())
            ->addElement(new ContractorUrlElement())
            ->addElement(new ContractorLegalAddressElement())
            ->addElement(new ContractorActualAddressElement())
            ->addElement(new ContractorRegistrationAddressElement())
            ->addElement(new ContractorIsArchiveElement())
            ->addElement(new NoteElement())
        ;
    }

    public function setValue($data): Form
    {
        parent::setValue($data);
        $idElement = $this->getElement('id');

        if ($idElement->isValid()) {
            $this->getElement('inn')
                ->addValidator($this->uniqueContractorInnValidator->setExceptId($idElement->getValue()))
            ;
        }

        // TODO подумать куда это вынести
        $customFieldIds = [];

        foreach ($data as $customFieldId => $value) {
            if (!$this->hasElement($customFieldId)) {
                if ($this->uuidGenerator->isValidV4($customFieldId)) {
                    $customFieldIds[$customFieldId] = $value;
                }
            }
        }

        /** @var ContractorCustomField $customField */
        foreach ($this->customFieldRepository->findAll(new CustomFieldUpdateFilter()) as $customField) {
            if (isset($customFieldIds[$customField->getId()])) {
                $customFieldElement = ($this->customFieldElementCreator->create($customField))
                    ->setName($customField->getId())
                    ->setValue($customFieldIds[$customField->getId()] ?? null);

                if ($customField->isRequiredOnUpdate()) {
                    $customFieldElement->isRequired();
                } else {
                    $customFieldElement->addFilter(new DefaultNullFilter());
                }

                $this->addElement($customFieldElement);
            }
        }

        return $this;
    }
}
