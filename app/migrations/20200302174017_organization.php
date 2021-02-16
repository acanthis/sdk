<?php

use Phinx\Migration\AbstractMigration;

class Organization extends AbstractMigration
{
    public function change()
    {
        $this->table('organization_status', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('color', 'string', ['limit' => 7, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        $this->table('organization', ['id' => false])
            ->addColumn('id', 'uuid')
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('status_id', 'uuid', ['null' => true])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('type', 'string', ['limit' => 2, 'null' => false])
            ->addColumn('short_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('inn', 'string', ['limit' => 12, 'null' => false])
            ->addColumn('full_name', 'text', ['null' => true])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('kpp', 'string', ['limit' => 9, 'null' => true])
            ->addColumn('ogrn', 'string', ['limit' => 13, 'null' => true])
            ->addColumn('ogrn_ip', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('okpo', 'string', ['limit' => 10, 'null' => true])
            ->addColumn('number_of_certificate', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('date_of_certificate', 'timestamp', ['timezone' => true, 'null' => true])
            ->addColumn('phone', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('phone_mobile', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('fax', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('url', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('legal_address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('actual_address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('registration_address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('note', 'text', ['null' => true])
            ->addColumn('is_archive', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['client_id', 'inn'], ['unique' => true])
            ->addForeignKey('status_id', 'organization_status', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_contact', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('post', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('phone', 'string', ['limit' => 15, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('note', 'text', ['null' => true])
            ->addColumn('is_default', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_bank_account', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('checking_account', 'string', ['limit' => 20, 'null' => false])
            ->addColumn('bank_identification_code', 'string', ['limit' => 9, 'null' => true])
            ->addColumn('correspondent_account', 'string', ['limit' => 20, 'null' => true])
            ->addColumn('bank_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('bank_address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('is_default', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('note', 'text', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_group', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        $this->table('organization_groups', ['id' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('group_id', 'uuid', ['null' => false])
            ->addIndex(['organization_id', 'group_id'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('group_id', 'organization_group', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_package_doc', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('expire', 'timestamp', ['timezone' => true, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['organization_id', 'name'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_package_doc_files', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('package_doc_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('original_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('file_path', 'text', ['null' => false])
            ->addColumn('size', 'integer', ['null' => false])
            ->addColumn('mime_type', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['package_doc_id', 'file_path'], ['unique' => true])
            ->addForeignKey('package_doc_id', 'organization_package_doc', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        $this->table('organization_custom_field', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 10, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('is_required_on_create', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_required_on_update', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_show_on_create', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_show_on_update', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_unique', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_use_in_filter', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('is_mark_on_delete', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('attributes', 'json', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        $this->table('organization_custom_field_values', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('custom_field_id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('value', 'text', ['null' => false])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['custom_field_id', 'organization_id'], ['unique' => true])
            ->addForeignKey('custom_field_id', 'organization_custom_field', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create()
        ;
    }
}