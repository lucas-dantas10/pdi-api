<?php

namespace App\Domain\Exception\Transaction;

class InsufficientBalanceException extends \Exception
{
    private const string MESSAGE = "Saldo insuficiente";

    public function __construct(?string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?? self::MESSAGE, $code, $previous);
    }
}
