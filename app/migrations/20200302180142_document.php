<?php

use Phinx\Migration\AbstractMigration;

class Document extends AbstractMigration
{
    public function change()
    {
        // Статусы документа
        $this->table('document_state', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => true])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('color', 'string', ['limit' => 7, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        // Типы документа
        $this->table('document_type', ['id' => false])
            ->addColumn('id', 'uuid')
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('document_new_state_default_id', 'uuid', ['null' => false])
            ->addColumn('document_complete_state_default_id', 'uuid', ['null' => false])
            ->addColumn('is_owner_document_require', 'boolean', ['null' => false])
            ->addColumn('is_needed_to_agreement', 'boolean', ['null' => false])
            ->addColumn('agreement_type', 'smallinteger', ['null' => false])
            ->addColumn('is_mark_on_delete', 'boolean', ['null' => false, 'default' => 'false'])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        // Документ
        $this->table('document', ['id' => false])
            ->addColumn('id', 'uuid')
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('state_id', 'uuid', ['null' => false])
            ->addColumn('type_id', 'uuid', ['null' => false])
            ->addColumn('handler_id', 'uuid', ['null' => true])
            ->addColumn('owner_id', 'uuid', ['null' => true])
            ->addColumn('is_mark_on_delete', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('type_id', 'document_type', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('type_id', 'document_type', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create()
        ;

        // Кастомные поля документа
        $this->table('document_custom_field', ['id' => false])
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

        // Связь кастомных полей с организациями и типами документов
        $this->table('document_custom_field_relationship', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('custom_field_id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('document_type_id', 'uuid', ['null' => false])
            ->addColumn('sequence', 'smallinteger', ['null' => false])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['custom_field_id', 'organization_id', 'document_type_id'], ['unique' => true])
            ->addForeignKey('custom_field_id', 'document_custom_field', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('document_type_id', 'document_type', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create()
        ;

        // Значения кастомных полей
        $this->table('document_custom_field_values', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('document_id', 'uuid', ['null' => false])
            ->addColumn('custom_field_id', 'uuid', ['null' => false])
            ->addColumn('value', 'text', ['null' => false])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['document_id', 'custom_field_id'], ['unique' => true])
            ->addForeignKey('custom_field_id', 'document_custom_field', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('document_id', 'document', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create()
        ;

        // Вложения
        $this->table('document_files', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('document_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('original_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('file_path', 'text', ['null' => false])
            ->addColumn('size', 'integer', ['null' => false])
            ->addColumn('mime_type', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addIndex(['document_id', 'file_path'], ['unique' => true])
            ->addForeignKey('document_id', 'document', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;
    }
}
