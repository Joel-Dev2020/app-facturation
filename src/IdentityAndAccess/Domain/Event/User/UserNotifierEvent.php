<?php

namespace App\IdentityAndAccess\Domain\Event\User;

use App\SharedKernel\Domain\Common\Event\DomainEventInterface;
use DateTimeImmutable;

class UserNotifierEvent implements DomainEventInterface
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        private string  $email,
        private string  $userId,
        private string  $subject,
        private ?string $message = null,
        private ?string $template = null,
        private ?array  $data = [],
    )
    {
        $this->occurredOn = new DateTimeImmutable();
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}