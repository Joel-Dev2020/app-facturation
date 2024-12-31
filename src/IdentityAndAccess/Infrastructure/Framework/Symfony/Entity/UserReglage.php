<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Repository\Orm\UserOrmReglageRepository;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Devise\Devise;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserOrmReglageRepository::class)]
#[ORM\Table(name: "user_reglages")]
class UserReglage
{
    use UidTrait;
    use DatesTrait;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 0])]
    private ?int $tva = 0;

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => true])]
    private ?bool $isDiscount = true;

    #[ORM\Column(type: 'string', length: 4, unique: true, nullable: true)]
    #[Assert\Length(max: 4, maxMessage: '{{ limit }} caractère autorisés')]
    private ?string $prefixNumeroInvoice = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'reglage')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Devise::class, inversedBy: 'reglage')]
    private ?Devise $devises = null;

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(?int $tva): UserReglage
    {
        $this->tva = $tva;
        return $this;
    }

    public function getPrefixNumeroInvoice(): ?string
    {
        return $this->prefixNumeroInvoice;
    }

    public function setPrefixNumeroInvoice(?string $prefixNumeroInvoice): UserReglage
    {
        $this->prefixNumeroInvoice = $prefixNumeroInvoice;
        return $this;
    }

    public function getIsDiscount(): ?bool
    {
        return $this->isDiscount;
    }

    public function setIsDiscount(?bool $isDiscount): UserReglage
    {
        $this->isDiscount = $isDiscount;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDevises(): ?Devise
    {
        return $this->devises;
    }

    public function setDevises(?Devise $devise): UserReglage
    {
        $this->devises = $devise;
        return $this;
    }

    public function __toString(): string
    {
        return $this->user->getFullname() ?? '';
    }

}
