<?php

use Phinx\Seed\AbstractSeed;

class AuthSeeder extends AbstractSeed
{
    const LOCALE = 'ru_RU';

    const AUTH_USER_TABLE = 'auth_user';
    const AUTH_ROLE_TABLE = 'auth_role';
    const AUTH_USER_HAS_ROLE_TABLE = 'auth_user_has_role';

    public function run()
    {
        $faker = Faker\Factory::create(self::LOCALE);
        $tablePrefix = $this->getAdapter()->getOption('table_prefix');
        $userTable = $this->table(self::AUTH_USER_TABLE);
        $roleTable = $this->table(self::AUTH_ROLE_TABLE);
        $authUserHasRoleTable = $this->table(self::AUTH_USER_HAS_ROLE_TABLE);

        $this->execute(
            sprintf(
                'TRUNCATE %s, %s, %s RESTART IDENTITY CASCADE',
                $tablePrefix.self::AUTH_USER_HAS_ROLE_TABLE,
                $tablePrefix.self::AUTH_ROLE_TABLE,
                $tablePrefix.self::AUTH_USER_TABLE
            )
        );

        $userData = [
            [
                'id' => $faker->uuid,
                'email' => 'super@user.com',
                'status' => 1,
                'password' => password_hash('test7777', PASSWORD_DEFAULT),
                'salt' => 'test7777',
                'created_at' => (new DateTime())->format(DateTime::ISO8601),
            ],
            [
                'id' => $faker->uuid,
                'email' => 'admin@app.com',
                'status' => 1,
                'password' => password_hash('test8888', PASSWORD_DEFAULT),
                'salt' => 'test8888',
                'created_at' => (new DateTime())->format(DateTime::ISO8601),
            ]
        ];

        $userTable->insert($userData)->save();
    }
}
