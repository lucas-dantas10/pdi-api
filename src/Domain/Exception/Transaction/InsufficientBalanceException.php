<?php

namespace App\Domain\Exception\Transaction;

use Exception;
use Throwable;

class InsufficientBalanceException extends Exception
{
    public const MESSAGE = "Saldo insuficiente";

    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? self::MESSAGE, $code, $previous);
    }
}
