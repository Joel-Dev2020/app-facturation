<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use App\IdentityAndAccess\Application\UseCase\User\Command\ChangeUserPasswordCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Presentation\Form\UsersChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('UserPasswordChangeModalFormComponent', template: 'identity_and_access/admin/user/components/user_change_password_modal_form_component.html.twig')]
class UserPasswordChangeModalFormComponents extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?string $userId = null;

    public string $id;

    public string $title;

    public ?string $urlPath = 'javascript:';

    #[LiveProp(writable: true)]
    public ?bool $isMe = false;

    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function mount(string $userId): void
    {
        $this->userId = $userId;
    }

    public function user(): User
    {
        return $this->repository->getById($this->userId);
    }

    /**
     * @return FormInterface
     */
    protected function instantiateForm(): FormInterface
    {
        $passwordRequest = new ChangeUserPasswordCommand(id: $this->userId);
        return $this->createForm(UsersChangePasswordType::class, $passwordRequest, ['isMe' => $this->isMe]);
    }
}