<?php

namespace App\Adapter\Email;

use App\Domain\ValueObject\Email\EmailVO;

interface EmailServiceGateway
{
    public function sendEmail(EmailVO $emailVO): void;
}
