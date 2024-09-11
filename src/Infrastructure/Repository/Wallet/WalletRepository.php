<?php

namespace App\Infrastructure\Repository\Wallet;

use App\Domain\Entity\Wallet;
use App\Domain\Repository\Wallet\WalletRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WalletRepository extends ServiceEntityRepository implements WalletRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function withdraw(Wallet $wallet, float $amount): void
    {
        $balance = $wallet->getBalance();
        $wallet->setBalance($balance - $amount);
    }

    public function deposit(Wallet $wallet, float $amount): void
    {
        $balance = $wallet->getBalance();
        $wallet->setBalance($balance + $amount);
    }

    public function findByUser(int $userId): Wallet
    {
        return current($this->findBy(["user" => $userId]));
    }

    public function persist(Wallet $wallet): void
    {
        $this->getEntityManager()->persist($wallet);
    }

    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    public function startTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commitTransaction(): void
    {
        $this->getEntityManager()->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
    }
}
