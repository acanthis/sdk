<?php

use Eds\Organization\Abstraction\ConfigInterface;
use Eds\Organization\Action\BankAccount\BankAccountCreateAction;
use Eds\Organization\Action\BankAccount\BankAccountDeleteAction;
use Eds\Organization\Action\BankAccount\BankAccountListAction;
use Eds\Organization\Action\BankAccount\BankAccountReadAction;
use Eds\Organization\Action\BankAccount\BankAccountUpdateAction;
use Eds\Organization\Action\Contact\ContactCreateAction;
use Eds\Organization\Action\Contact\ContactDeleteAction;
use Eds\Organization\Action\Contact\ContactListAction;
use Eds\Organization\Action\Contact\ContactReadAction;
use Eds\Organization\Action\Contact\ContactUpdateAction;
use Eds\Organization\Action\Organization\OrganizationCreateAction;
use Eds\Organization\Action\Organization\OrganizationDeleteAction;
use Eds\Organization\Action\Organization\OrganizationListAction;
use Eds\Organization\Action\Organization\OrganizationReadAction;
use Eds\Organization\Action\Organization\OrganizationArchiveAction;
use Eds\Organization\Action\Organization\OrganizationUpdateAction;
use Eds\Organization\Action\CustomField\CustomFieldCreateAction;
use Eds\Organization\Action\CustomField\CustomFieldMarkAsDeleteAction;
use Eds\Organization\Action\CustomField\CustomFieldListAction;
use Eds\Organization\Action\CustomField\CustomFieldReadAction;
use Eds\Organization\Action\CustomField\CustomFieldUnMarkAsDeleteAction;
use Eds\Organization\Action\CustomField\CustomFieldUpdateAction;
use Eds\Organization\Action\Group\GroupCreateAction;
use Eds\Organization\Action\Group\GroupDeleteAction;
use Eds\Organization\Action\Group\GroupListAction;
use Eds\Organization\Action\Group\GroupReadAction;
use Eds\Organization\Action\Group\GroupUpdateAction;
use Eds\Organization\Action\PackageDoc\PackageDocCreateAction;
use Eds\Organization\Action\PackageDoc\PackageDocDeleteAction;
use Eds\Organization\Action\PackageDoc\PackageDocListAction;
use Eds\Organization\Action\PackageDoc\PackageDocReadAction;
use Eds\Organization\Action\PackageDoc\PackageDocUpdateAction;
use Eds\Organization\Action\PackageDocFile\PackageDocFileCreateAction;
use Eds\Organization\Action\PackageDocFile\PackageDocFileDeleteAction;
use Eds\Organization\Action\PackageDocFile\PackageDocFileListAction;
use Eds\Organization\Action\PackageDocFile\PackageDocFileReadAction;
use Eds\Organization\Action\PackageDocFile\PackageDocFileUpdateAction;
use Eds\Organization\Action\Status\StatusCreateAction;
use Eds\Organization\Action\Status\StatusDeleteAction;
use Eds\Organization\Action\Status\StatusListAction;
use Eds\Organization\Action\Status\StatusReadAction;
use Eds\Organization\Action\Status\StatusUpdateAction;
use Eds\Organization\Persistence\Abstraction\Repository\BankAccountRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\ContactRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\OrganizationRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\CustomFieldRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\CustomFieldValueRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\GroupRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\PackageDocFileRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\PackageDocRepositoryInterface;
use Eds\Organization\Persistence\Abstraction\Repository\StatusRepositoryInterface;
use Eds\Organization\Persistence\Repository\PgSqlBankAccountRepository;
use Eds\Organization\Persistence\Repository\PgSqlContactRepository;
use Eds\Organization\Persistence\Repository\PgSqlOrganizationRepository;
use Eds\Organization\Persistence\Repository\PgSqlCustomFieldRepository;
use Eds\Organization\Persistence\Repository\PgSqlCustomFieldValueRepository;
use Eds\Organization\Persistence\Repository\PgSqlGroupRepository;
use Eds\Organization\Persistence\Repository\PgSqlPackageDocFileRepository;
use Eds\Organization\Persistence\Repository\PgSqlPackageDocRepository;
use Eds\Organization\Persistence\Repository\PgSqlStatusRepository;
use Eds\Organization\Persistence\Schema\PgSqlBankAccountSchema;
use Eds\Organization\Persistence\Schema\PgSqlContactSchema;
use Eds\Organization\Persistence\Schema\PgSqlOrganizationSchema;
use Eds\Organization\Persistence\Schema\PgSqlCustomFieldSchema;
use Eds\Organization\Persistence\Schema\PgSqlCustomFieldValueSchema;
use Eds\Organization\Persistence\Schema\PgSqlGroupSchema;
use Eds\Organization\Persistence\Schema\PgSqlPackageDocFileSchema;
use Eds\Organization\Persistence\Schema\PgSqlPackageDocSchema;
use Eds\Organization\Persistence\Schema\PgSqlStatusSchema;
use Eds\Organization\Service\Config;

return [
    'routes' => [
        '/organization/create' => OrganizationCreateAction::class,
        '/organization/update' => OrganizationUpdateAction::class,
        '/organization/read' => OrganizationReadAction::class,
        '/organization/delete' => OrganizationDeleteAction::class,
        '/organization/list' => OrganizationListAction::class,
        '/organization/archive' => OrganizationArchiveAction::class,
        '/organization/contact/create' => ContactCreateAction::class,
        '/organization/contact/update' => ContactUpdateAction::class,
        '/organization/contact/read' => ContactReadAction::class,
        '/organization/contact/delete' => ContactDeleteAction::class,
        '/organization/contact/list' => ContactListAction::class,
        '/organization/bank_account/create' => BankAccountCreateAction::class,
        '/organization/bank_account/update' => BankAccountUpdateAction::class,
        '/organization/bank_account/read' => BankAccountReadAction::class,
        '/organization/bank_account/delete' => BankAccountDeleteAction::class,
        '/organization/bank_account/list' => BankAccountListAction::class,
        '/organization/status/create' => StatusCreateAction::class,
        '/organization/status/update' => StatusUpdateAction::class,
        '/organization/status/read' => StatusReadAction::class,
        '/organization/status/delete' => StatusDeleteAction::class,
        '/organization/status/list' => StatusListAction::class,
        '/organization/group/create' => GroupCreateAction::class,
        '/organization/group/update' => GroupUpdateAction::class,
        '/organization/group/read' => GroupReadAction::class,
        '/organization/group/delete' => GroupDeleteAction::class,
        '/organization/group/list' => GroupListAction::class,
        '/organization/package_doc/create' => PackageDocCreateAction::class,
        '/organization/package_doc/update' => PackageDocUpdateAction::class,
        '/organization/package_doc/read' => PackageDocReadAction::class,
        '/organization/package_doc/delete' => PackageDocDeleteAction::class,
        '/organization/package_doc/list' => PackageDocListAction::class,
        '/organization/package_doc_file/create' => PackageDocFileCreateAction::class,
        '/organization/package_doc_file/update' => PackageDocFileUpdateAction::class,
        '/organization/package_doc_file/read' => PackageDocFileReadAction::class,
        '/organization/package_doc_file/delete' => PackageDocFileDeleteAction::class,
        '/organization/package_doc_file/list' => PackageDocFileListAction::class,
        '/organization/custom_field/create' => CustomFieldCreateAction::class,
        '/organization/custom_field/update' => CustomFieldUpdateAction::class,
        '/organization/custom_field/read' => CustomFieldReadAction::class,
        '/organization/custom_field/mark_as_delete' => CustomFieldMarkAsDeleteAction::class,
        '/organization/custom_field/unmark_as_delete' => CustomFieldUnMarkAsDeleteAction::class,
        '/organization/custom_field/list' => CustomFieldListAction::class,
    ],
    'services' => [
        OrganizationRepositoryInterface::class => PgSqlOrganizationRepository::class,
        ContactRepositoryInterface::class => PgSqlContactRepository::class,
        BankAccountRepositoryInterface::class => PgSqlBankAccountRepository::class,
        StatusRepositoryInterface::class => PgSqlStatusRepository::class,
        GroupRepositoryInterface::class => PgSqlGroupRepository::class,
        PackageDocRepositoryInterface::class => PgSqlPackageDocRepository::class,
        PackageDocFileRepositoryInterface::class => PgSqlPackageDocFileRepository::class,
        CustomFieldRepositoryInterface::class => PgSqlCustomFieldRepository::class,
        CustomFieldValueRepositoryInterface::class => PgSqlCustomFieldValueRepository::class,
        PgSqlOrganizationSchema::class => [PgSqlOrganizationSchema::class, 'tableName' => $_ENV['ORGANIZATION_DB_TABLE_NAME']],
        PgSqlContactSchema::class => [PgSqlContactSchema::class, 'tableName' => $_ENV['ORGANIZATION_CONTACT_DB_TABLE_NAME']],
        PgSqlBankAccountSchema::class => [PgSqlBankAccountSchema::class, 'tableName' => $_ENV['ORGANIZATION_BANK_ACCOUNT_DB_TABLE_NAME']],
        PgSqlStatusSchema::class => [PgSqlStatusSchema::class, 'tableName' => $_ENV['ORGANIZATION_STATUS_DB_TABLE_NAME']],
        PgSqlGroupSchema::class => [PgSqlGroupSchema::class, 'tableName' => $_ENV['ORGANIZATION_GROUP_DB_TABLE_NAME']],
        PgSqlPackageDocSchema::class => [PgSqlPackageDocSchema::class, 'tableName' => $_ENV['ORGANIZATION_PACKAGE_DOC_DB_TABLE_NAME']],
        PgSqlPackageDocFileSchema::class => [PgSqlPackageDocFileSchema::class, 'tableName' => $_ENV['ORGANIZATION_PACKAGE_DOC_FILES_DB_TABLE_NAME']],
        PgSqlCustomFieldSchema::class => [PgSqlCustomFieldSchema::class, 'tableName' => $_ENV['ORGANIZATION_CUSTOM_FIELD_DB_TABLE_NAME']],
        PgSqlCustomFieldValueSchema::class => [PgSqlCustomFieldValueSchema::class, 'tableName' => $_ENV['ORGANIZATION_CUSTOM_FIELD_VALUES_DB_TABLE_NAME']],
        ConfigInterface::class => [
            Config::class,
            'packageDoc' => [
                'filePathPattern' => $_ENV['ORGANIZATION_PACKAGE_DOC_FILE_PATH_PATTERN'],
                'maxFileSize' => $_ENV['ORGANIZATION_PACKAGE_DOC_MAX_FILE_SIZE'],
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
