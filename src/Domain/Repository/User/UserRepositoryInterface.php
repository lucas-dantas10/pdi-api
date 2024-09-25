<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function startTransaction(): void;
    public function commitTransaction(): void;
    public function rollbackTransaction(): void;
    public function persist(User $user): void;
    public function save(): void;
}
