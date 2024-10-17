<?php

namespace App\Infrastructure\Repository\Transaction;

use App\Domain\Entity\Transaction;
use App\Domain\Repository\Transaction\TransactionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    #[\Override]
    public function save(Transaction $transaction): void
    {
        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function startTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    #[\Override]
    public function commitTransaction(): void
    {
        $this->getEntityManager()->commit();
    }

    #[\Override]
    public function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
    }
}
