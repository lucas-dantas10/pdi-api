<?php

namespace App\Domain\Builder\Wallet;

use App\Domain\Entity\User;
use App\Domain\Entity\Wallet;

interface WalletBuilderInterface
{
    public function build(User $user): Wallet;
}
