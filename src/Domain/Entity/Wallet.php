<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Wallet
{
    private readonly int $id;
    private User $user;
    private float $balance;
    private Collection $sentTransactions;
    private Collection $receivedTransactions;

    public function __construct()
    {
        $this->sentTransactions = new ArrayCollection();
        $this->receivedTransactions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Wallet
    {
        $this->user = $user;

        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): Wallet
    {
        $this->balance = $balance;

        return $this;
    }

    public function getSentTransactions(): Collection
    {
        return $this->sentTransactions;
    }

    public function setSentTransactions(Collection $sentTransactions): Wallet
    {
        $this->sentTransactions = $sentTransactions;

        return $this;
    }

    public function addSentTransaction(Transaction $transaction): void
    {
        $this->sentTransactions->add($transaction);
    }

    public function getReceivedTransactions(): Collection
    {
        return $this->receivedTransactions;
    }

    public function setReceivedTransactions(Collection $receivedTransactions): Wallet
    {
        $this->receivedTransactions = $receivedTransactions;

        return $this;
    }

    public function addReceivedTransaction(Transaction $transaction): void
    {
        $this->receivedTransactions->add($transaction);
    }
}
