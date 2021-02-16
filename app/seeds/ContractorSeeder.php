<?php

use Phinx\Seed\AbstractSeed;

class ContractorSeeder extends AbstractSeed
{
    const CONTRACTOR_COUNT = 10;
    const CONTRACTOR_TABLE = 'contractor';
    const CONTRACTOR_CONTACT_TABLE = 'contractor_contact';
    const CONTRACTOR_BANK_ACCOUNT_TABLE = 'contractor_bank_account';
    const CONTRACTOR_STATUS_TABLE = 'contractor_status';
    const CONTRACTOR_GROUP_TABLE = 'contractor_group';
    const CONTRACTOR_GROUPS_TABLE = 'contractor_groups';

    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');

        $contractorData = [];
        $contractorContactsData = [];
        $contractorBankAccountsData = [];
        $contractorStatusData = [];
        $contractorGroupData = [];
        $contractorGroupsData = [];
        $tablePrefix = $this->getAdapter()->getOption('table_prefix');

        $this->execute(
            sprintf(
                'TRUNCATE %s, %s, %s, %s, %s RESTART IDENTITY CASCADE',
                $tablePrefix.self::CONTRACTOR_GROUP_TABLE,
                $tablePrefix.self::CONTRACTOR_CONTACT_TABLE,
                $tablePrefix.self::CONTRACTOR_BANK_ACCOUNT_TABLE,
                $tablePrefix.self::CONTRACTOR_STATUS_TABLE,
                $tablePrefix.self::CONTRACTOR_TABLE
            )
        );

        $contractorTable = $this->table(self::CONTRACTOR_TABLE);
        $contractorContactTable = $this->table(self::CONTRACTOR_CONTACT_TABLE);
        $contractorBankAccountTable = $this->table(self::CONTRACTOR_BANK_ACCOUNT_TABLE);
        $contractorStatusTable = $this->table(self::CONTRACTOR_STATUS_TABLE);
        $contractorGroupTable = $this->table(self::CONTRACTOR_GROUP_TABLE);
        $contractorGroupsTable = $this->table(self::CONTRACTOR_GROUPS_TABLE);

        for ($i = 0; $i < 5; ++$i) {
            $contractorStatusData[] = [
                'id' => $faker->uuid,
                'client_id' => $faker->uuid,
                'creator_id' => $faker->uuid,
                'name' => $faker->colorName,
                'color' => $faker->hexColor,
                'created_at' => $faker->iso8601,
            ];
        }

        for ($i = 0; $i < 5; ++$i) {
            $contractorGroupData[] = [
                'id' => $faker->uuid,
                'client_id' => $faker->uuid,
                'creator_id' => $faker->uuid,
                'name' => $faker->word,
                'created_at' => $faker->iso8601,
            ];
        }

        for ($i = 0; $i < self::CONTRACTOR_COUNT; ++$i) {
            $companyName = $faker->company;
            $contractorData[] = [
                'id' => $faker->uuid,
                'client_id' => $faker->uuid,
                'status_id' => $contractorStatusData[$faker->numberBetween(0, 4)]['id'],
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

        foreach ($contractorData as $contractor) {
            $contractorId = $contractor['id'];
            $isDefault = true;
            $countContacts = $faker->numberBetween(1, 4);
            $countBankAccounts = $faker->numberBetween(1, 4);
            $countStatus = $faker->numberBetween(1, 4);

            for ($i = 0; $i < $countContacts; ++$i) {
                $contractorContactsData[] = [
                    'id' => $faker->uuid,
                    'contractor_id' => $contractorId,
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
                $contractorBankAccountsData[] = [
                    'id' => $faker->uuid,
                    'contractor_id' => $contractorId,
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
                $contractorStatusData[] = [
                    'id' => $faker->uuid,
                    'client_id' => $faker->uuid,
                    'creator_id' => $faker->uuid,
                    'name' => $faker->colorName,
                    'color' => $faker->hexColor,
                    'created_at' => $faker->iso8601,
                ];
            }

            $contractorGroupsData[] = [
                'contractor_id' => $contractorId,
                'group_id' => $contractorGroupData[$faker->numberBetween(0, 4)]['id'],
            ];

        }

        $contractorStatusTable->insert($contractorStatusData)->save();
        $contractorGroupTable->insert($contractorGroupData)->save();
        $contractorTable->insert($contractorData)->save();
        $contractorContactTable->insert($contractorContactsData)->save();
        $contractorBankAccountTable->insert($contractorBankAccountsData)->save();
        $contractorGroupsTable->insert($contractorGroupsData)->save();
    }
}
