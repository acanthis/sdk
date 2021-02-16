<?php

namespace Eds\Contractor\Persistence\Repository;

use Eds\Contractor\Entity\Contractor;
use Eds\Contractor\Persistence\Abstraction\Repository\ContractorRepositoryInterface;
use Eds\Contractor\Persistence\Factory\ContractorFactory;
use Eds\Contractor\Persistence\Schema\PgSqlContractorSchema;
use Nrg\Data\Collection;
use Nrg\Data\Condition\EqualCondition;
use Nrg\Data\Dto\Filter;
use Nrg\Data\Exception\EntityNotFoundException;

class PgSqlContractorRepository implements ContractorRepositoryInterface
{
    private PgSqlContractorSchema $contractorSchema;
    private ContractorFactory $contractorFactory;

    public function __construct(PgSqlContractorSchema $contractorSchema, ContractorFactory $contractorFactory)
    {
        $this->contractorSchema = $contractorSchema;
        $this->contractorFactory = $contractorFactory;
    }

//    public function read(string $id): Entity
//    {
//        $data = $this->createQuery()
//            ->select($this->getFieldNames())
//            ->from($this->getFullTableName(), 'c')
//            ->leftJoin(
//                'c',
//                "(SELECT cc.contractor_id as cc_cid, COUNT(cc.id) as contacts_count FROM {$this->contactSchema->getFullTableName()} cc GROUP BY cc_cid)",
//                'cc',
//                'c.id = cc_cid'
//            )
//            ->leftJoin(
//                'c',
//                "(SELECT ba.contractor_id as ba_cid, COUNT(ba.id) as bank_accounts_count FROM {$this->bankAccountSchema->getFullTableName()} ba GROUP BY ba_cid)",
//                'ba',
//                'c.id = ba_cid'
//            )
//            ->leftJoin(
//                'c',
//                "(SELECT pd.contractor_id as pd_cid, COUNT(pd.id) as package_docs_files_count FROM {$this->packageDocSchema->getFullTableName()} pd GROUP BY pd_cid)",
//                'pd',
//                'c.id = pd_cid'
//            )
//            ->where('id = :id')
//            ->setParameter('id', $id, PDO::PARAM_STR)
//            ->execute()
//            ->fetch()
//        ;
//
//        if (false === $data) {
//            throw new EntityNotFoundException('Entity was not found');
//        }
//
//        return $this->getFactory()->createEntity($data);
//    }

    public function findAll(object ...$dtoList): Collection
    {

        $iterator = $this->contractorSchema->findAll(...$dtoList);
        $total = $this->contractorSchema->count(...$dtoList);

        return $this->contractorFactory
            ->createCollection($iterator)
            ->setTotal($total)
        ;

//           $data = $this->createQuery(
//               new FilterScope($this->getSchemaAdapter(), $filter),
//               new SortingScope($this->getSchemaAdapter(), $sorting),
//               new PaginationScope($pagination)
//           )
//               ->select($this->getFieldNames())
//               ->from($this->getFullTableName(), 'c')
//               ->leftJoin(
//                   'c',
//                   "(SELECT cc.contractor_id as cc_cid, COUNT(cc.id) as contacts_count FROM {$this->contactSchema->getFullTableName()} cc GROUP BY cc_cid)",
//                   'cc',
//                   'c.id = cc_cid'
//               )
//               ->leftJoin(
//                   'c',
//                   "(SELECT ba.contractor_id as ba_cid, COUNT(ba.id) as bank_accounts_count FROM {$this->bankAccountSchema->getFullTableName()} ba GROUP BY ba_cid)",
//                   'ba',
//                   'c.id = ba_cid'
//               )
//               ->leftJoin(
//                   'c',
//                   "(SELECT pd.contractor_id as pd_cid, COUNT(pd.id) as package_docs_files_count FROM {$this->packageDocSchema->getFullTableName()} pd GROUP BY pd_cid)",
//                   'pd',
//                   'c.id = pd_cid'
//               )
//               ->execute()
//               ->fetchAll();

//        $total = $this->createQuery(
//            new FilterScope($this->getSchemaAdapter(), $filter)
//        )
//            ->select('COUNT(id)')
//            ->from($this->getFullTableName())
//            ->execute()
//            ->fetchColumn();
//
//        return $this->getFactory()
//            ->createCollection($data)
//            ->setTotal($total)
//            ->setPagination($pagination);
    }

    public function create(Contractor $contractor): void
    {
        $this->contractorSchema->insert(
            $this->contractorFactory->arrayToCreate($contractor)
        );
    }

    public function update(Contractor $contractor, array $fields = null): int
    {
        $filter = (new Filter())
            ->addCondition(
                (new EqualCondition())
                    ->setValue($contractor->getId())
                    ->setField('id')
            )
        ;

        return $this->contractorSchema->update(
            $this->contractorFactory->arrayToUpdate($contractor, $fields),
            $filter
        );
    }

    public function delete(Filter $filter): int
    {
        return $this->contractorSchema->delete($filter);
    }

    public function findOne(?object ...$dtoList): ?Contractor
    {
        $contractor = $this->contractorSchema->findOne(...$dtoList);

        if (null === $contractor) {
            throw new EntityNotFoundException('Contractor was not found');
        }

        return $this->contractorFactory->createEntity($contractor);
    }

    public function exists(Filter $filter): bool
    {
        return $this->contractorSchema->exists($filter);
    }
}
