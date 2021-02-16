<?php

use Eds\Document\Action\CustomField\DocumentCustomFieldCreateAction;
use Eds\Document\Action\CustomField\DocumentCustomFieldListAction;
use Eds\Document\Action\CustomField\DocumentCustomFieldMarkAsDeleteAction;
use Eds\Document\Action\CustomField\DocumentCustomFieldReadAction;
use Eds\Document\Action\CustomField\DocumentCustomFieldUnMarkAsDeleteAction;
use Eds\Document\Action\CustomField\DocumentCustomFieldUpdateAction;
use Eds\Document\Action\Document\DocumentCreateAction;
use Eds\Document\Action\Document\DocumentListAction;
use Eds\Document\Action\Document\DocumentReadAction;
use Eds\Document\Action\Document\DocumentUpdateAction;
use Eds\Document\Action\DocumentType\DocumentTypeCreateAction;
use Eds\Document\Event\Document\DocumentCreateEvent;
use Eds\Document\Middleware\Document\AgreementCreate;
use Eds\Document\Persistence\Abstraction\Repository\ChainReferenceMemberRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\ChainReferenceRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentAgreementStepRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentCustomFieldRelationshipRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentCustomFieldRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentCustomFieldValueRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentFileRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentStateRepositoryInterface;
use Eds\Document\Persistence\Abstraction\Repository\DocumentTypeRepositoryInterface;
use Eds\Document\Persistence\Repository\PgSqlChainReferenceMemberRepository;
use Eds\Document\Persistence\Repository\PgSqlChainReferenceRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentAgreementStepRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentCustomFieldRelationshipRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentCustomFieldRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentCustomFieldValueRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentFileRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentStateRepository;
use Eds\Document\Persistence\Repository\PgSqlDocumentTypeRepository;
use Eds\Document\Persistence\Schema\PgSqlChainReferenceMemberSchema;
use Eds\Document\Persistence\Schema\PgSqlChainReferenceSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentAgreementStepSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentCustomFieldRelationshipSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentCustomFieldSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentCustomFieldValueSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentFileSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentStateSchema;
use Eds\Document\Persistence\Schema\PgSqlDocumentTypeSchema;
use Eds\Organization\Abstraction\ConfigInterface;
use Eds\Organization\Service\Config;

return [
    'routes' => [
        '/document/create' => DocumentCreateAction::class,
        '/document/read' => DocumentReadAction::class,
        '/document/list' => DocumentListAction::class,
        '/document/update' => DocumentUpdateAction::class,

        '/document_type/create' => DocumentTypeCreateAction::class,

        '/document/custom_field/create' => DocumentCustomFieldCreateAction::class,
        '/document/custom_field/update' => DocumentCustomFieldUpdateAction::class,
        '/document/custom_field/read' => DocumentCustomFieldReadAction::class,
        '/document/custom_field/mark_as_delete' => DocumentCustomFieldMarkAsDeleteAction::class,
        '/document/custom_field/unmark_as_delete' => DocumentCustomFieldUnMarkAsDeleteAction::class,
        '/document/custom_field/list' => DocumentCustomFieldListAction::class,
    ],
    'services' => [
        DocumentRepositoryInterface::class => PgSqlDocumentRepository::class,
        DocumentTypeRepositoryInterface::class => PgSqlDocumentTypeRepository::class,
        DocumentStateRepositoryInterface::class => PgSqlDocumentStateRepository::class,
        DocumentFileRepositoryInterface::class => PgSqlDocumentFileRepository::class,
        DocumentCustomFieldRepositoryInterface::class => PgSqlDocumentCustomFieldRepository::class,
        DocumentCustomFieldRelationshipRepositoryInterface::class => PgSqlDocumentCustomFieldRelationshipRepository::class,
        DocumentCustomFieldValueRepositoryInterface::class => PgSqlDocumentCustomFieldValueRepository::class,
        DocumentAgreementStepRepositoryInterface::class => PgSqlDocumentAgreementStepRepository::class,
        ChainReferenceRepositoryInterface::class => PgSqlChainReferenceRepository::class,
        ChainReferenceMemberRepositoryInterface::class => PgSqlChainReferenceMemberRepository::class,
        PgSqlDocumentSchema::class => [PgSqlDocumentSchema::class, 'tableName' => $_ENV['DOCUMENT_DB_TABLE_NAME']],
        PgSqlDocumentTypeSchema::class => [PgSqlDocumentTypeSchema::class, 'tableName' => $_ENV['DOCUMENT_TYPE_DB_TABLE_NAME']],
        PgSqlDocumentStateSchema::class => [PgSqlDocumentStateSchema::class, 'tableName' => $_ENV['DOCUMENT_STATE_DB_TABLE_NAME']],
        PgSqlDocumentFileSchema::class => [PgSqlDocumentFileSchema::class, 'tableName' => $_ENV['DOCUMENT_FILE_DB_TABLE_NAME']],
        PgSqlDocumentCustomFieldSchema::class => [PgSqlDocumentCustomFieldSchema::class, 'tableName' => $_ENV['DOCUMENT_CUSTOM_FIELD_DB_TABLE_NAME']],
        PgSqlDocumentCustomFieldRelationshipSchema::class => [PgSqlDocumentCustomFieldRelationshipSchema::class, 'tableName' => $_ENV['DOCUMENT_CUSTOM_FIELD_RELATIONSHIP_DB_TABLE_NAME']],
        PgSqlDocumentCustomFieldValueSchema::class => [PgSqlDocumentCustomFieldValueSchema::class, 'tableName' => $_ENV['DOCUMENT_CUSTOM_FIELD_VALUE_DB_TABLE_NAME']],
        PgSqlDocumentAgreementStepSchema::class => [PgSqlDocumentAgreementStepSchema::class, 'tableName' => $_ENV['DOCUMENT_AGREEMENT_STEP_DB_TABLE_NAME']],
        PgSqlChainReferenceSchema::class => [PgSqlChainReferenceSchema::class, 'tableName' => $_ENV['AGREEMENT_CHAIN_REFERENCE_DB_TABLE_NAME']],
        PgSqlChainReferenceMemberSchema::class => [PgSqlChainReferenceMemberSchema::class, 'tableName' => $_ENV['AGREEMENT_CHAIN_REFERENCE_MEMBER_DB_TABLE_NAME']],

        ConfigInterface::class => [
            Config::class,
            'documentFile' => [
                'filePathPattern' => $_ENV['DOCUMENT_FILE_PATH_PATTERN'],
                'maxFileSize' => $_ENV['DOCUMENT_MAX_FILE_SIZE'],
                'allowTypes' => [
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'pdf' => 'application/pdf',
                ],
            ],
        ],
    ],
    'events' => [
        DocumentCreateEvent::class => [
            AgreementCreate::class,
        ],
    ],
];
