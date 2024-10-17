<?php

namespace App\Application\Builder\Wallet;

use App\Domain\Builder\Wallet\WalletBuilderInterface;
use App\Domain\Entity\User;
use App\Domain\Entity\Wallet;

class WalletBuilder implements WalletBuilderInterface
{
    #[\Override]
    public function build(User $user): Wallet
    {
        return (new Wallet())
            ->setUser($user)
            ->setBalance(0.0);
    }
}
