<?php

use Eds\Contractor\Abstraction\ConfigInterface;
use Eds\Contractor\Action\BankAccount\BankAccountCreateAction;
use Eds\Contractor\Action\BankAccount\BankAccountDeleteAction;
use Eds\Contractor\Action\BankAccount\BankAccountListAction;
use Eds\Contractor\Action\BankAccount\BankAccountReadAction;
use Eds\Contractor\Action\BankAccount\BankAccountUpdateAction;
use Eds\Contractor\Action\Contact\ContactCreateAction;
use Eds\Contractor\Action\Contact\ContactDeleteAction;
use Eds\Contractor\Action\Contact\ContactListAction;
use Eds\Contractor\Action\Contact\ContactReadAction;
use Eds\Contractor\Action\Contact\ContactUpdateAction;
use Eds\Contractor\Action\Contractor\ContractorCreateAction;
use Eds\Contractor\Action\Contractor\ContractorDeleteAction;
use Eds\Contractor\Action\Contractor\ContractorListAction;
use Eds\Contractor\Action\Contractor\ContractorReadAction;
use Eds\Contractor\Action\Contractor\ContractorArchiveAction;
use Eds\Contractor\Action\Contractor\ContractorUpdateAction;
use Eds\Contractor\Action\CustomField\CustomFieldCreateAction;
use Eds\Contractor\Action\CustomField\CustomFieldMarkAsDeleteAction;
use Eds\Contractor\Action\CustomField\CustomFieldListAction;
use Eds\Contractor\Action\CustomField\CustomFieldReadAction;
use Eds\Contractor\Action\CustomField\CustomFieldUnMarkAsDeleteAction;
use Eds\Contractor\Action\CustomField\CustomFieldUpdateAction;
use Eds\Contractor\Action\Group\GroupCreateAction;
use Eds\Contractor\Action\Group\GroupDeleteAction;
use Eds\Contractor\Action\Group\GroupListAction;
use Eds\Contractor\Action\Group\GroupReadAction;
use Eds\Contractor\Action\Group\GroupUpdateAction;
use Eds\Contractor\Action\PackageDoc\PackageDocCreateAction;
use Eds\Contractor\Action\PackageDoc\PackageDocDeleteAction;
use Eds\Contractor\Action\PackageDoc\PackageDocListAction;
use Eds\Contractor\Action\PackageDoc\PackageDocReadAction;
use Eds\Contractor\Action\PackageDoc\PackageDocUpdateAction;
use Eds\Contractor\Action\PackageDocFile\PackageDocFileCreateAction;
use Eds\Contractor\Action\PackageDocFile\PackageDocFileDeleteAction;
use Eds\Contractor\Action\PackageDocFile\PackageDocFileListAction;
use Eds\Contractor\Action\PackageDocFile\PackageDocFileReadAction;
use Eds\Contractor\Action\PackageDocFile\PackageDocFileUpdateAction;
use Eds\Contractor\Action\Status\StatusCreateAction;
use Eds\Contractor\Action\Status\StatusDeleteAction;
use Eds\Contractor\Action\Status\StatusListAction;
use Eds\Contractor\Action\Status\StatusReadAction;
use Eds\Contractor\Action\Status\StatusUpdateAction;
use Eds\Contractor\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\CustomFieldValueRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Contractor\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Eds\Contractor\Persistence\Repository\PgSqlBankAccountRepository;
use Eds\Contractor\Persistence\Repository\PgSqlContactRepository;
use Eds\Contractor\Persistence\Repository\PgSqlContractorRepository;
use Eds\Contractor\Persistence\Repository\PgSqlCustomFieldRepository;
use Eds\Contractor\Persistence\Repository\PgSqlCustomFieldValueRepository;
use Eds\Contractor\Persistence\Repository\PgSqlGroupRepository;
use Eds\Contractor\Persistence\Repository\PgSqlPackageDocFileRepository;
use Eds\Contractor\Persistence\Repository\PgSqlPackageDocRepository;
use Eds\Contractor\Persistence\Repository\PgSqlStatusRepository;
use Eds\Contractor\Persistence\Schema\PgSqlBankAccountSchema;
use Eds\Contractor\Persistence\Schema\PgSqlContactSchema;
use Eds\Contractor\Persistence\Schema\PgSqlContractorSchema;
use Eds\Contractor\Persistence\Schema\PgSqlCustomFieldSchema;
use Eds\Contractor\Persistence\Schema\PgSqlCustomFieldValueSchema;
use Eds\Contractor\Persistence\Schema\PgSqlGroupSchema;
use Eds\Contractor\Persistence\Schema\PgSqlPackageDocFileSchema;
use Eds\Contractor\Persistence\Schema\PgSqlPackageDocSchema;
use Eds\Contractor\Persistence\Schema\PgSqlStatusSchema;
use Eds\Contractor\Service\Config;

return [
    'routes' => [
        '/contractor/create' => ContractorCreateAction::class,
        '/contractor/update' => ContractorUpdateAction::class,
        '/contractor/read' => ContractorReadAction::class,
        '/contractor/delete' => ContractorDeleteAction::class,
        '/contractor/list' => ContractorListAction::class,
        '/contractor/archive' => ContractorArchiveAction::class,
        '/contractor/contact/create' => ContactCreateAction::class,
        '/contractor/contact/update' => ContactUpdateAction::class,
        '/contractor/contact/read' => ContactReadAction::class,
        '/contractor/contact/delete' => ContactDeleteAction::class,
        '/contractor/contact/list' => ContactListAction::class,
        '/contractor/bank_account/create' => BankAccountCreateAction::class,
        '/contractor/bank_account/update' => BankAccountUpdateAction::class,
        '/contractor/bank_account/read' => BankAccountReadAction::class,
        '/contractor/bank_account/delete' => BankAccountDeleteAction::class,
        '/contractor/bank_account/list' => BankAccountListAction::class,
        '/contractor/status/create' => StatusCreateAction::class,
        '/contractor/status/update' => StatusUpdateAction::class,
        '/contractor/status/read' => StatusReadAction::class,
        '/contractor/status/delete' => StatusDeleteAction::class,
        '/contractor/status/list' => StatusListAction::class,
        '/contractor/group/create' => GroupCreateAction::class,
        '/contractor/group/update' => GroupUpdateAction::class,
        '/contractor/group/read' => GroupReadAction::class,
        '/contractor/group/delete' => GroupDeleteAction::class,
        '/contractor/group/list' => GroupListAction::class,
        '/contractor/package_doc/create' => PackageDocCreateAction::class,
        '/contractor/package_doc/update' => PackageDocUpdateAction::class,
        '/contractor/package_doc/read' => PackageDocReadAction::class,
        '/contractor/package_doc/delete' => PackageDocDeleteAction::class,
        '/contractor/package_doc/list' => PackageDocListAction::class,
        '/contractor/package_doc_file/create' => PackageDocFileCreateAction::class,
        '/contractor/package_doc_file/update' => PackageDocFileUpdateAction::class,
        '/contractor/package_doc_file/read' => PackageDocFileReadAction::class,
        '/contractor/package_doc_file/delete' => PackageDocFileDeleteAction::class,
        '/contractor/package_doc_file/list' => PackageDocFileListAction::class,
        '/contractor/custom_field/create' => CustomFieldCreateAction::class,
        '/contractor/custom_field/update' => CustomFieldUpdateAction::class,
        '/contractor/custom_field/read' => CustomFieldReadAction::class,
        '/contractor/custom_field/mark_as_delete' => CustomFieldMarkAsDeleteAction::class,
        '/contractor/custom_field/unmark_as_delete' => CustomFieldUnMarkAsDeleteAction::class,
        '/contractor/custom_field/list' => CustomFieldListAction::class,
    ],
    'services' => [
        ContractorRepositoryInterface::class => PgSqlContractorRepository::class,
        ContactRepositoryInterface::class => PgSqlContactRepository::class,
        BankAccountRepositoryInterface::class => PgSqlBankAccountRepository::class,
        StatusRepositoryInterface::class => PgSqlStatusRepository::class,
        GroupRepositoryInterface::class => PgSqlGroupRepository::class,
        PackageDocRepositoryInterface::class => PgSqlPackageDocRepository::class,
        PackageDocFileRepositoryInterface::class => PgSqlPackageDocFileRepository::class,
        CustomFieldRepositoryInterface::class => PgSqlCustomFieldRepository::class,
        CustomFieldValueRepositoryInterface::class => PgSqlCustomFieldValueRepository::class,
        PgSqlContractorSchema::class => [PgSqlContractorSchema::class, 'tableName' => $_ENV['CONTRACTOR_DB_TABLE_NAME']],
        PgSqlContactSchema::class => [PgSqlContactSchema::class, 'tableName' => $_ENV['CONTRACTOR_CONTACT_DB_TABLE_NAME']],
        PgSqlBankAccountSchema::class => [PgSqlBankAccountSchema::class, 'tableName' => $_ENV['CONTRACTOR_BANK_ACCOUNT_DB_TABLE_NAME']],
        PgSqlStatusSchema::class => [PgSqlStatusSchema::class, 'tableName' => $_ENV['CONTRACTOR_STATUS_DB_TABLE_NAME']],
        PgSqlGroupSchema::class => [PgSqlGroupSchema::class, 'tableName' => $_ENV['CONTRACTOR_GROUP_DB_TABLE_NAME']],
        PgSqlPackageDocSchema::class => [PgSqlPackageDocSchema::class, 'tableName' => $_ENV['CONTRACTOR_PACKAGE_DOC_DB_TABLE_NAME']],
        PgSqlPackageDocFileSchema::class => [PgSqlPackageDocFileSchema::class, 'tableName' => $_ENV['CONTRACTOR_PACKAGE_DOC_FILES_DB_TABLE_NAME']],
        PgSqlCustomFieldSchema::class => [PgSqlCustomFieldSchema::class, 'tableName' => $_ENV['CONTRACTOR_CUSTOM_FIELD_DB_TABLE_NAME']],
        PgSqlCustomFieldValueSchema::class => [PgSqlCustomFieldValueSchema::class, 'tableName' => $_ENV['CONTRACTOR_CUSTOM_FIELD_VALUES_DB_TABLE_NAME']],
        ConfigInterface::class => [
            Config::class,
            'packageDoc' => [
                'filePathPattern' => $_ENV['CONTRACTOR_PACKAGE_DOC_FILE_PATH_PATTERN'],
                'maxFileSize' => $_ENV['CONTRACTOR_PACKAGE_DOC_MAX_FILE_SIZE'],
                'allowTypes' => [
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'pdf' => 'application/pdf',
                ],
            ],
            'search' => [ // getSearch()
                'apiKey' => '294c92b63330f0d7a9549416e4d6edb1454f9b96',
                'url' => 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party',
            ],
        ],
    ],
];
