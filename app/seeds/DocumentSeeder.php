<?php

use Phinx\Seed\AbstractSeed;

class DocumentSeeder extends AbstractSeed
{
    const DOCUMENT_TABLE = 'document';
    const DOCUMENT_STATE_TABLE = 'document_state';
    const DOCUMENT_TYPE_TABLE = 'document_type';
    const DOCUMENT_CUSTOM_FIELD_TABLE = 'document_custom_field';
    const DOCUMENT_CUSTOM_FIELD_RELATIONSHIP_TABLE = 'document_custom_field_relationship';

    public function getDependencies()
    {
        return [
            'AuthSeeder',
            'ContractorSeeder',
            'OrganizationSeeder',
        ];
    }

    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');
        $tablePrefix = $this->getAdapter()->getOption('table_prefix');
        $this->execute(
            sprintf(
                'TRUNCATE %s, %s, %s, %s, %s RESTART IDENTITY CASCADE',
                $tablePrefix.self::DOCUMENT_TABLE,
                $tablePrefix.self::DOCUMENT_STATE_TABLE,
                $tablePrefix.self::DOCUMENT_TYPE_TABLE,
                $tablePrefix.self::DOCUMENT_CUSTOM_FIELD_TABLE,
                $tablePrefix.self::DOCUMENT_CUSTOM_FIELD_RELATIONSHIP_TABLE,
            )
        );

        $documentTable = $this->table(self::DOCUMENT_TABLE);
        $documentStateTable = $this->table(self::DOCUMENT_STATE_TABLE);
        $documentTypeTable = $this->table(self::DOCUMENT_TYPE_TABLE);
        $documentCustomFieldTable = $this->table(self::DOCUMENT_CUSTOM_FIELD_TABLE);
        $documentCustomFieldRelationshipTable = $this->table(self::DOCUMENT_CUSTOM_FIELD_RELATIONSHIP_TABLE);

        $clientId = $faker->uuid;
        $creatorId = $faker->uuid;
        $documentStateData = [];
        $documentTypeData = [];
        $documentCustomFieldData = [];
        $documentCustomFieldRelationshipData = [];

        $documentStates = [
            [
                'id' => 'f1cbbb81-ded4-47a0-86c4-84b8b6e4c679',
                'name' => 'На согласовании',
            ],
            [
                'id' => 'abf939f8-024e-4563-944c-97dec80daa15',
                'name' => 'На повторном согласовании',
            ],
            [
                'id' => '25947b88-dc72-4a21-95a6-9bdcad517e54',
                'name' => 'Отклолнен',
            ],
            [
                'id' => '82b87f34-8585-4025-868a-a519fdc6cbba',
                'name' => 'Приостановлен',
            ],
            [
                'id' => '4a1adf2f-2f69-4763-a894-4820c9baf009',
                'name' => 'Помечен на удаление',
            ],
            [
                'id' => '201cf72c-4261-40b7-9b50-4946b84e3cef',
                'name' => 'На подписи',
            ],
            [
                'id' => '2b3494a8-a263-489e-8356-2390cca3ccec',
                'name' => 'В реестре',
            ],
        ];

        $documentTypes = [
            [
                'id' => 'e3bf9292-0338-4b59-9d25-d961cd4a960c',
                'name' => 'Договор',
            ],
            [
                'id' => '309f090c-b2c3-488d-a3a0-2d6f7578763e',
                'name' => 'Доверенность',
            ],
            [
                'id' => '482a6bda-b33c-4fb8-bbd5-e67d433f9596',
                'name' => 'Доп. соглашение',
            ],
            [
                'id' => '092377cc-b401-44a7-b80b-635f46fad1ad',
                'name' => 'Спецификация',
            ],
        ];

        $documentCustomFields = [
            [
                'id' => '4c22f1f9-cc9e-46de-9791-e49484b4192b',
                'name' => 'Контрагент',
                'type' => 'systemList',
                'description' => 'Контрагент 1',
                'attributes' => ['relationName' => 'contractor'],
            ],
            [
                'id' => 'b19ddb4e-3eca-4e49-9e2e-650fc7b66d49',
                'name' => 'Организация',
                'type' => 'systemList',
                'description' => 'Организация',
                'attributes' => ['relationName' => 'organization'],
            ],
        ];

        foreach ($documentStates as $documentState) {
           $documentStateData[] = [
                'id' => $documentState['id'],
                'creator_id' => $creatorId,
                'name' => $documentState['name'],
                'color' => $faker->hexColor,
                'created_at' => $faker->iso8601,
            ];
        }

        foreach ($documentTypes as $documentType) {
            $documentTypeData[] = [
                'id' => $documentType['id'],
                'client_id' => $clientId,
                'creator_id' => $creatorId,
                'name' => $documentType['name'],
                'document_new_state_default' => $faker->uuid,
                'document_complete_state_default' => $faker->uuid,
                'is_owner_document_require' => $faker->boolean,
                'is_needed_to_agreement' => $faker->boolean,
                'agreement_type' => $faker->numberBetween(1, 2),
                'is_mark_on_delete' => false,
                'created_at' => $faker->iso8601,
            ];
        }

        foreach ($documentCustomFields as $documentCustomField) {
            $documentCustomFieldData[] = [
                'id' => $documentCustomField['id'],
                'client_id' => $faker->uuid,
                'creator_id' => $faker->uuid,
                'name' => $documentCustomField['name'],
                'description' => $documentCustomField['description'],
                'type' => $documentCustomField['type'],
                'attributes' => json_encode($documentCustomField['attributes']),
                'created_at' => $faker->iso8601,
            ];
        }

        $documentCustomFieldRelationshipData[] = [
            'id' => $faker->uuid,
            'custom_field_id' => '4c22f1f9-cc9e-46de-9791-e49484b4192b',
            'organization_id' => OrganizationSeeder::MAIN_ORGANIZATION_ID,
            'document_type_id' => 'e3bf9292-0338-4b59-9d25-d961cd4a960c',
            'sequence' => 1,
        ];

        $documentCustomFieldRelationshipData[] = [
            'id' => $faker->uuid,
            'custom_field_id' => 'b19ddb4e-3eca-4e49-9e2e-650fc7b66d49',
            'organization_id' => OrganizationSeeder::MAIN_ORGANIZATION_ID,
            'document_type_id' => 'e3bf9292-0338-4b59-9d25-d961cd4a960c',
            'sequence' => 2,
        ];

        $documentStateTable->insert($documentStateData)->save();
        $documentTypeTable->insert($documentTypeData)->save();
        $documentCustomFieldTable->insert($documentCustomFieldData)->save();
        $documentCustomFieldRelationshipTable->insert($documentCustomFieldRelationshipData)->save();
    }
}
