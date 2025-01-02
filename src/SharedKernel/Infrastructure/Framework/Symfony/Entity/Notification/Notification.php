<?php

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Notification;

use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Notification\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\Table(name: "notifications")]
class Notification
{
    use UidTrait;
    use DatesTrait;

    public const ACTIONS = [
        'add' => 'Ajout',
        'edit' => 'Modification',
        'delete' => 'Suppression',
    ];
    public const ACTION_ADD = 'add';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::STRING, length: 30, options: ['default' => 'add'])]
    private ?string $action = 'add';

    #[ORM\Column(type: Types::STRING, length: 30)]
    private ?string $channel = null;

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => false])]
    private ?bool $read_at = false;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
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

    public function setChannel(?string $channel): void
    {
        $this->channel = $channel;
    }

    public function getReadAt(): ?bool
    {
        return $this->read_at;
    }

    public function setReadAt(?bool $read_at): self
    {
        $this->read_at = $read_at;

        return $this;
    }

    public function getActionValue(): ?string
    {
        return self::ACTIONS[$this->action];
    }

    public function __toString(): string
    {
        return $this->channel;
    }
}
