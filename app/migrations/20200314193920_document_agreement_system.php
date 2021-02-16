<?php

use Phinx\Migration\AbstractMigration;

class DocumentAgreementSystem extends AbstractMigration
{
    public function change()
    {
        // Эталонные цепочки согласования
        $this->table('chain_reference', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('client_id', 'uuid', ['null' => false])
            ->addColumn('creator_id', 'uuid', ['null' => false])
            ->addColumn('organization_id', 'uuid', ['null' => false])
            ->addColumn('document_type_id', 'uuid', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('organization_id', 'organization', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('document_type_id', 'document_type', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        // Список согласовантов в эталонных цепочках
        $this->table('chain_reference_members', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('chain_reference_id', 'uuid', ['null' => false])
            ->addColumn('member_id', 'uuid', ['null' => false])
            ->addColumn('sequence', 'smallinteger', ['null' => false])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('chain_reference_id', 'chain_reference', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;

        // Результаты фактического согласования документа (этапы согласования)
        $this->table('document_agreement_steps', ['id' => false])
            ->addColumn('id', 'uuid', ['null' => false])
            ->addColumn('document_id', 'uuid', ['null' => false])
            ->addColumn('member_id', 'uuid', ['null' => false])
            ->addColumn('sequence', 'smallinteger', ['null' => false])
            ->addColumn('agreement_state_id', 'smallinteger', ['null' => false])
            ->addColumn('agreement_date_time', 'timestamp', ['timezone' => true, 'null' => false])
            ->addIndex(['id'], ['unique' => true])
            ->addForeignKey('document_id', 'document', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create()
        ;
    }
}
