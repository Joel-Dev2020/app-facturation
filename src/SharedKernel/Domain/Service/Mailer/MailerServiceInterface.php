<?php

namespace App\SharedKernel\Domain\Service\Mailer;

interface MailerServiceInterface
{
    public function send(string $to, string $subject, ?string $body = null, ?string $template = null): void;
}