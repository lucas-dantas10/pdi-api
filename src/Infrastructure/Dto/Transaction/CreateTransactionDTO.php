<?php

namespace App\Infrastructure\Dto\Transaction;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateTransactionDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "Campo de value é obrigatório.")]
        #[SerializedName(serializedName: "value")]
        #[Assert\NotNull(message: "Campo de value é não pode estar null.")]
        #[Assert\Type(type: "float", message: "O valor deve ser um float.")]
        private float $value,

        #[Assert\NotBlank(message: "Campo de payer é obrigatório.")]
        #[SerializedName(serializedName: "payer")]
        #[Assert\NotNull(message: "Campo de payer é não pode estar null.")]
        #[Assert\Type(type: "integer", message: "O valor deve ser um float.")]
        private int $payer,

        #[Assert\NotBlank(message: "Campo de payee é obrigatório.")]
        #[SerializedName(serializedName: "payee")]
        #[Assert\NotNull(message: "Campo de payee é não pode estar null.")]
        #[Assert\Type(type: "integer", message: "O valor deve ser um float.")]
        private int $payee
    ) { }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getPayer(): int
    {
        return $this->payer;
    }

    public function getPayee(): int
    {
        return $this->payee;
    }
}
