<?php

namespace App\Domain\Service\Email;

use App\Domain\Entity\User;

interface EmailServiceInterface
{
    public function sendEmail(User $user): void;
}
