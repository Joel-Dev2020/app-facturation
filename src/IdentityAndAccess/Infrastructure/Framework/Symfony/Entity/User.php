<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\Trait\PermissionsTrait;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\Trait\UserRolesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity]
#[ORM\Table(name: "user")]
#[ORM\Index(name: 'idx_name', columns: ['name'])]
#[ORM\Index(name: 'idx_email', columns: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use UidTrait;
    use DatesTrait;
    use UserRolesTrait;
    use PermissionsTrait;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $organization = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $address = null;

    #[ORM\Column]
    private array $roles;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean', nullable: true, options: ["default" => false])]
    private ?bool $enabled = false;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'users')]
    private ?self $owner = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'owner')]
    private Collection $users;

    public function __construct()
    {
        $this->roles = ["ROLE_USER"];
        $this->users = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): User
    {
        $this->phone = $phone;
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
        $roles = $this->roles;
        // Si le tableau est vide, retourner ROLE_USER
        if (empty($roles)) {
            return ['ROLE_USER'];
        }
        return $roles;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): User
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getFullname(): string
    {
        return $this->name;
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

    public function getOwner(): ?self
    {
        return $this->owner;
    }

    public function setOwner(?self $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
