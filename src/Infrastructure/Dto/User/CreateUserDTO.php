<?php

namespace App\Infrastructure\Dto\User;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "Campo de nome full_name é obrigatório.")]
        #[SerializedName(serializedName: "full_name")]
        #[Assert\NotNull(message: "Campo de full_name não pode estar null.")]
        #[Assert\Type(type: "string", message: "O valor deve ser string")]
        private string $fullName,

        #[Assert\NotBlank(message: "Campo de email é obrigatório.")]
        #[SerializedName(serializedName: "email")]
        #[Assert\NotNull(message: "Campo de email não pode estar null.")]
        #[Assert\Type(type: "string", message: "O valor deve ser string.")]
        private string $email,

        #[Assert\NotBlank(message: "Campo de password é obrigatório.")]
        #[SerializedName(serializedName: "password")]
        #[Assert\NotNull(message: "Campo de password não pode estar null.")]
        #[Assert\Type(type: "string", message: "O valor deve ser string")]
        private string $password
    ) {
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}