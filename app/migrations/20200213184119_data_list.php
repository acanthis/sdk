<?php

use Phinx\Migration\AbstractMigration;

class DataList extends AbstractMigration
{
    public function change()
    {
        $this->table('data_list', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('is_mark_on_delete', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;

        $this->table('data_list_values', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('data_list_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('value', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('is_mark_on_delete', 'boolean', ['default' => 'false', 'null' => false])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addForeignKey('data_list_id', 'data_list', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addIndex(['id'], ['unique' => true])
            ->create()
        ;
    }
}
