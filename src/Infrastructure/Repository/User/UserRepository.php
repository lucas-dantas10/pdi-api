<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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
    public function persist(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    #[\Override]
    public function save(): void
    {
        $this->getEntityManager()->flush();
    }

    #[\Override]
    public function persistAndSave(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
