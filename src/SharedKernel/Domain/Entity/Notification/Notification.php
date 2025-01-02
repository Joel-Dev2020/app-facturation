<?php

namespace App\SharedKernel\Domain\Entity\Notification;

use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;

class Notification
{
    use DatesTrait;

    public readonly ?string $id;
    private ?string $content;
    private ?string $action;
    private ?string $channel;
    private ?bool $read_at;

    public function __construct(
        ?string $content = null,
        ?string $action = null,
        ?string $channel = null,
        ?int    $id = null,
        ?bool   $read_at = null,
        ?bool   $createdAt = null,
        ?bool   $updatedAt = null,
    )
    {
        $this->id = $id;
        $this->content = $content;
        $this->action = $action;
        $this->channel = $channel;
        $this->read_at = $read_at;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Notification
    {
        $this->content = $content;
        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): Notification
    {
        $this->action = $action;
        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): Notification
    {
        $this->channel = $channel;
        return $this;
    }

    public function getReadAt(): ?bool
    {
        return $this->read_at;
    }

    public function setReadAt(?bool $read_at): Notification
    {
        $this->read_at = $read_at;
        return $this;
    }
}