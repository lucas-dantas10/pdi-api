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

    public function setSenderWallet(Wallet $senderWallet): Transaction
    {
        $this->senderWallet = $senderWallet;
        return $this;
    }

    public function getReceiverWallet(): Wallet
    {
        return $this->receiverWallet;
    }

    public function setReceiverWallet(Wallet $receiverWallet): Transaction
    {
        $this->receiverWallet = $receiverWallet;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Transaction
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
