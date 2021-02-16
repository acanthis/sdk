<?php

use Phinx\Seed\AbstractSeed;

class OrganizationSeeder extends AbstractSeed
{
    const ORGANIZATION_COUNT = 5;
    const ORGANIZATION_TABLE = 'organization';
    const ORGANIZATION_CONTACT_TABLE = 'organization_contact';
    const ORGANIZATION_BANK_ACCOUNT_TABLE = 'organization_bank_account';
    const ORGANIZATION_STATUS_TABLE = 'organization_status';
    const ORGANIZATION_GROUP_TABLE = 'organization_group';
    const ORGANIZATION_GROUPS_TABLE = 'organization_groups';

    const MAIN_ORGANIZATION_ID = 'babdd385-81c7-4cc8-abf3-3ee856596f39';

    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');

        $organizationData = [];
        $organizationContactsData = [];
        $organizationBankAccountsData = [];
        $organizationStatusData = [];
        $organizationGroupData = [];
        $organizationGroupsData = [];
        $tablePrefix = $this->getAdapter()->getOption('table_prefix');

        $this->execute(
            sprintf(
                'TRUNCATE %s, %s, %s, %s, %s RESTART IDENTITY CASCADE',
                $tablePrefix.self::ORGANIZATION_GROUP_TABLE,
                $tablePrefix.self::ORGANIZATION_CONTACT_TABLE,
                $tablePrefix.self::ORGANIZATION_BANK_ACCOUNT_TABLE,
                $tablePrefix.self::ORGANIZATION_STATUS_TABLE,
                $tablePrefix.self::ORGANIZATION_TABLE
            )
        );

        $organizationTable = $this->table(self::ORGANIZATION_TABLE);
        $organizationContactTable = $this->table(self::ORGANIZATION_CONTACT_TABLE);
        $organizationBankAccountTable = $this->table(self::ORGANIZATION_BANK_ACCOUNT_TABLE);
        $organizationStatusTable = $this->table(self::ORGANIZATION_STATUS_TABLE);
        $organizationGroupTable = $this->table(self::ORGANIZATION_GROUP_TABLE);
        $organizationGroupsTable = $this->table(self::ORGANIZATION_GROUPS_TABLE);

        for ($i = 0; $i < 5; ++$i) {
            $organizationStatusData[] = [
                'id' => $faker->uuid,
                'client_id' => $faker->uuid,
                'creator_id' => $faker->uuid,
                'name' => $faker->colorName,
                'color' => $faker->hexColor,
                'created_at' => $faker->iso8601,
            ];
        }

        for ($i = 0; $i < 5; ++$i) {
            $organizationGroupData[] = [
                'id' => $faker->uuid,
                'client_id' => $faker->uuid,
                'creator_id' => $faker->uuid,
                'name' => $faker->word,
                'created_at' => $faker->iso8601,
            ];
        }

        for ($i = 0; $i < self::ORGANIZATION_COUNT; ++$i) {
            $companyName = $faker->company;
            $organizationData[] = [
                'id' => $i === 1 ? self::MAIN_ORGANIZATION_ID : $faker->uuid,
                'client_id' => $faker->uuid,
                'status_id' => $organizationStatusData[$faker->numberBetween(0, 4)]['id'],
                'creator_id' => $faker->uuid,
                'type' => $faker->randomElement(['SP', 'PE', 'EN']),
                'short_name' => $companyName,
                'full_name' => $companyName,
                'inn' => $faker->inn,
                'kpp' => $faker->kpp,
                'phone' => $faker->e164PhoneNumber,
                'email' => $faker->companyEmail,
                'legal_address' => $faker->address,
                'created_at' => $faker->iso8601,
            ];
        }

        foreach ($organizationData as $organization) {
            $organizationId = $organization['id'];
            $isDefault = true;
            $countContacts = $faker->numberBetween(1, 4);
            $countBankAccounts = $faker->numberBetween(1, 4);
            $countStatus = $faker->numberBetween(1, 4);

            for ($i = 0; $i < $countContacts; ++$i) {
                $organizationContactsData[] = [
                    'id' => $faker->uuid,
                    'organization_id' => $organizationId,
                    'creator_id' => $faker->uuid,
                    'name' => $faker->name,
                    'post' => $faker->jobTitle,
                    'phone' => $faker->e164PhoneNumber,
                    'email' => $faker->email,
                    'note' => $faker->text(80),
                    'is_default' => $isDefault ? 'true' : 'false',
                    'created_at' => $faker->iso8601,
                ];
                $isDefault = false;
            }

            $isDefault = true;

            for ($i = 0; $i < $countBankAccounts; ++$i) {
                $organizationBankAccountsData[] = [
                    'id' => $faker->uuid,
                    'organization_id' => $organizationId,
                    'creator_id' => $faker->uuid,
                    'bank_identification_code' => $faker->kpp,
                    'correspondent_account' => $faker->creditCardNumber,
                    'checking_account' => $faker->creditCardNumber,
                    'bank_name' => $faker->bank,
                    'bank_address' => $faker->address,
                    'note' => $faker->text(80),
                    'is_default' => $isDefault ? 'true' : 'false',
                    'created_at' => $faker->iso8601,
                ];
                $isDefault = false;
            }

            for ($i = 0; $i < $countStatus; ++$i) {
                $organizationStatusData[] = [
                    'id' => $faker->uuid,
                    'client_id' => $faker->uuid,
                    'creator_id' => $faker->uuid,
                    'name' => $faker->colorName,
                    'color' => $faker->hexColor,
                    'created_at' => $faker->iso8601,
                ];
            }

            $organizationGroupsData[] = [
                'organization_id' => $organizationId,
                'group_id' => $organizationGroupData[$faker->numberBetween(0, 4)]['id'],
            ];

        }

        $organizationStatusTable->insert($organizationStatusData)->save();
        $organizationGroupTable->insert($organizationGroupData)->save();
        $organizationTable->insert($organizationData)->save();
        $organizationContactTable->insert($organizationContactsData)->save();
        $organizationBankAccountTable->insert($organizationBankAccountsData)->save();
        $organizationGroupsTable->insert($organizationGroupsData)->save();
    }
}
