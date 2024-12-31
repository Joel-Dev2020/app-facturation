<?php

namespace App\IdentityAndAccess\Domain\Entity;

use App\IdentityAndAccess\Domain\Entity\Trait\DateTrait;
use App\IdentityAndAccess\Domain\Entity\Trait\UserRolesTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{
    use DateTrait;
    use UserRolesTrait;

    public readonly ?string $id;
    public ?self $owner = null;
    public Collection $users;
    private string $organization;
    private string $name;
    private string $email;
    private string $password;
    private ?string $phone_number;
    private ?string $address;
    private array $roles;
    private ?bool $is_enabled;

    public function __construct(
        string     $organization,
        string     $name,
        string     $email,
        string     $password,
        string     $phone_number = null,
        string     $address = null,
        bool       $is_enabled = false,
        ?string    $id = null,
        array      $roles = [],
        ?self      $owner = null,
        Collection $users = new ArrayCollection(),
    )
    {
        $this->id = $id;
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone_number = $phone_number;
        $this->address = $address;
        $this->roles = $roles;
        $this->is_enabled = $is_enabled;
        $this->owner = $owner;
        $this->users = $users;
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

    public function updateProfile(
        ?string $organization = null,
        ?string $name = null,
        ?string $email = null,
        ?string $phone_number = null,
        ?string $address = null,
    ): self
    {
        $this->organization = $organization;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->address = $address;
        return $this;
    }
}