<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Repository\Orm\UserOrmRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as TUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class SecurityUserProvider implements UserProviderInterface
{
    public function __construct(private UserOrmRepository $repository)
    {
    }

    /**
     * @param TUser $user
     * @return TUser
     */
    public function refreshUser(TUser $user): TUser
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    /**
     * @param string $identifier
     * @return TUser
     */
    public function loadUserByIdentifier(string $identifier): TUser
    {
        $user = $this->repository->getByEmail($identifier);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return SecurityUser::create($user);
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return $class === SecurityUser::class;
    }
}