<?php

namespace App\IdentityAndAccess\Domain\Entity;

use App\IdentityAndAccess\Domain\Entity\Feature\UserEventFeature;
use App\IdentityAndAccess\Domain\Entity\Trait\DateTrait;
use App\IdentityAndAccess\Domain\Entity\Trait\UserRolesTrait;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{
    use DateTrait;
    use UserRolesTrait;
    use UserEventFeature;

    public ?string $id;
    public ?self $owner = null;
    public Collection $users;
    private string $organization;
    private string $name;
    private string $email;
    private string $password;
    private ?string $passwordResetToken;
    private ?DateTimeInterface $passwordResetRequestedAt;
    private ?DateTimeInterface $passwordResetExpiresAt;
    private ?string $phone_number;
    private ?string $address;
    private array $roles;
    private ?bool $is_enabled;
    private ?bool $is_free;
    private ?UserReglage $reglage;

    public function __construct(
        string             $organization,
        string             $name,
        string             $email,
        string             $password,
        ?string            $passwordResetToken = null,
        ?DateTimeInterface $passwordResetRequestedAt = null,
        ?DateTimeInterface $passwordResetExpiresAt = null,
        string             $phone_number = null,
        string             $address = null,
        bool               $is_enabled = false,
        bool               $is_free = false,
        ?string            $id = null,
        array              $roles = [],
        ?self              $owner = null,
        ?UserReglage       $reglage = null,
        Collection         $users = new ArrayCollection(),
    )
    {
        $this->id = $id;
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordResetToken = $passwordResetToken;
        $this->passwordResetRequestedAt = $passwordResetRequestedAt;
        $this->passwordResetExpiresAt = $passwordResetExpiresAt;
        $this->phone_number = $phone_number;
        $this->address = $address;
        $this->roles = $roles;
        $this->is_enabled = $is_enabled;
        $this->is_free = $is_free;
        $this->owner = $owner;
        $this->users = $users;
        $this->reglage = $reglage;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): User
    {
        $this->organization = $organization;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): User
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    public function getPasswordResetRequestedAt(): ?DateTimeInterface
    {
        return $this->passwordResetRequestedAt;
    }

    public function setPasswordResetRequestedAt(?DateTimeInterface $passwordResetRequestedAt): User
    {
        $this->passwordResetRequestedAt = $passwordResetRequestedAt;
        return $this;
    }

    public function getPasswordResetExpiresAt(): ?DateTimeInterface
    {
        return $this->passwordResetExpiresAt;
    }

    public function setPasswordResetExpiresAt(?DateTimeInterface $passwordResetExpiresAt): User
    {
        $this->passwordResetExpiresAt = $passwordResetExpiresAt;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): User
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): User
    {
        $this->address = $address;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    public function getIsFree(): ?bool
    {
        return $this->is_free;
    }

    public function setIsFree(?bool $is_free): User
    {
        $this->is_free = $is_free;
        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->is_enabled;
    }

    public function setIsEnabled(?bool $is_enabled): User
    {
        $this->is_enabled = $is_enabled;
        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setOwner($this);
        }

        return $this;
    }

    public function removeUser(self $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOwner() === $this) {
                $user->setOwner(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): User
    {
        $this->owner = $owner;
        return $this;
    }

    public function getReglage(): ?UserReglage
    {
        return $this->reglage;
    }

    public function setReglage(?UserReglage $reglage): User
    {
        $this->reglage = $reglage;
        return $this;
    }

    public function isPasswordResetTokenExpired(): bool
    {
        if (!$this->passwordResetRequestedAt) {
            return true;
        }
        // Jeton valide pendant 24 heures, par exemple
        $expirationDate = (clone $this->passwordResetRequestedAt)->modify('+24 hours');
        return new DateTimeImmutable() > $expirationDate;
    }
}