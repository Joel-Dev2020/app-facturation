<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security;

use App\IdentityAndAccess\Domain\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private function __construct(
        public string      $id,
        public string      $organization,
        public string      $name,
        public string      $phone,
        private string     $email,
        private string     $password,
        private array      $roles,
        public bool        $enabled,
        public bool        $isSuperAdmin,
        public bool        $isAdmin,
        public bool        $isUser,
        public bool        $isStandard,
        public bool        $isPremium,
        public ?string     $address = null,
        private ?self      $owner = null,
        private Collection $users = new ArrayCollection(),
    )
    {
    }

    public static function create(User $user): self
    {
        return new self(
            id: $user->id,
            organization: $user->getOrganization(),
            name: $user->getName(),
            phone: $user->getPhoneNumber(),
            email: $user->getEmail(),
            password: $user->getPassword(),
            roles: $user->getRoles(),
            enabled: $user->getIsEnabled(),
            isSuperAdmin: $user->isSuperAdmin(),
            isAdmin: $user->isAdmin(),
            isUser: $user->isUser(),
            isStandard: $user->isStandard(),
            isPremium: $user->isPremium(),
            address: $user->getAddress(),
            owner: $user->getOwner(),
            users: $user->getUsers(),
        );
    }

    public function getOrganization(): string
    {
        return $this->organization;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getOwner(): ?SecurityUser
    {
        return $this->owner;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}