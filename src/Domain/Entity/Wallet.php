<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Wallet
{
    private int $id;
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

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function getSentTransactions(): Collection
    {
        return $this->sentTransactions;
    }

    public function setSentTransactions(Collection $sentTransactions): void
    {
        $this->sentTransactions = $sentTransactions;
    }

    public function addSentTransaction(Transaction $transaction): void
    {
        $this->sentTransactions->add($transaction);
    }

    public function getReceivedTransactions(): Collection
    {
        return $this->receivedTransactions;
    }

    public function setReceivedTransactions(Collection $receivedTransactions): void
    {
        $this->receivedTransactions = $receivedTransactions;
    }

    public function addReceivedTransaction(Transaction $transaction): void
    {
        $this->receivedTransactions->add($transaction);
    }
}
