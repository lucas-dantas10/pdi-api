<?php

namespace App\Domain\Entity;

use DateTime;

class Transaction
{
    private int $id;
    private Wallet $senderWallet;
    private Wallet $receiverWallet;
    private float $amount;
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSenderWallet(): Wallet
    {
        return $this->senderWallet;
    }

    public function setSenderWallet(Wallet $senderWallet): void
    {
        $this->senderWallet = $senderWallet;
    }

    public function getReceiverWallet(): Wallet
    {
        return $this->receiverWallet;
    }

    public function setReceiverWallet(Wallet $receiverWallet): void
    {
        $this->receiverWallet = $receiverWallet;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
