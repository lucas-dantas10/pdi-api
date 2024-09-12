<?php

namespace App\Domain\ValueObject\Email;

class EmailVO
{
    public function __construct(
        private string $to,
        private string $from
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
