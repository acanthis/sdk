<?php

use Phinx\Migration\AbstractMigration;

class Auth extends AbstractMigration
{
    public function change()
    {
        $this->table('auth_user', ['id' => false])
            ->addColumn('id', 'uuid')
            ->addColumn('owner_id', 'uuid', ['null' => true])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('status', 'smallinteger', ['null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('salt', 'text', ['null' => false])
            ->addColumn('permissions', 'json', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true, 'name' => 'idx_auth_user_id'])
            ->addIndex(['email'], ['unique' => true, 'name' => 'idx_auth_user_email'])
            ->create();

        // todo: permissions have priority under roles
        // request: {/docs/list, clientFilter: {....}}

        // new Filter(AND)
        //  ->addCondition(notEqual)
//          ->addFilter(clientFilter)

        // [{name: readDocs, companyId: 79879, excludeDocId: eq3231}]
        // [{name: readOneDoc, docId: 79879}, .....]

        // request: {/docs/list, filter:{union: AND, notEqual, clientFilter: {....}}}

        //$this->user->hasAccess(Action::READ_DOCS) {}

        $this->table('auth_role', ['id' => false])
            ->addColumn('id', 'uuid')
            ->addColumn('owner_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 50])
            ->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('permissions', 'json')
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true, 'name' => 'idx_auth_role_id'])
            ->addIndex(['owner_id', 'name'], ['unique' => true, 'name' => 'idx_auth_role_owner_id_name'])
            ->create();

        $this->table('auth_user_has_role', ['id' => false])
            ->addColumn('user_id', 'uuid')
            ->addColumn('role_id', 'uuid')
            ->addIndex(['user_id', 'role_id'], ['unique' => true, 'name' => 'idx_auth_user_has_role_user_id_role_id'])
            ->addForeignKey('user_id', 'auth_user', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_auth_user_has_role_user_id'])
            ->addForeignKey('role_id', 'auth_role', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_auth_user_has_role_role_id'])
            ->create()
        ;
    }
}