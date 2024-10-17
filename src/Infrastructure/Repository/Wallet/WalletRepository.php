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

    #[\Override]
    public function withdraw(Wallet $wallet, float $amount): void
    {
        $balance = $wallet->getBalance();
        $wallet->setBalance($balance - $amount);
    }

    #[\Override]
    public function deposit(Wallet $wallet, float $amount): void
    {
        $balance = $wallet->getBalance();
        $wallet->setBalance($balance + $amount);
    }

    #[\Override]
    public function findByUser(int $userId): Wallet
    {
        return current($this->findBy(["user" => $userId]));
    }

    #[\Override]
    public function persist(Wallet $wallet): void
    {
        $this->getEntityManager()->persist($wallet);
    }

    #[\Override]
    public function save(): void
    {
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

    #[\Override]
    public function persistAndSave(Wallet $wallet): void
    {
        $this->getEntityManager()->persist($wallet);
        $this->getEntityManager()->flush();
    }
}
