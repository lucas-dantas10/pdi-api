<?php

namespace App\Domain\ValueObject\Email;

class EmailVO
{
    public function __construct(
        private readonly string $to,
        private readonly string $from,
    ) {
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }
}
