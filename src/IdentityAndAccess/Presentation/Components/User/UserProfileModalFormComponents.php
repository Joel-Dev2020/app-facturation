<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use App\IdentityAndAccess\Application\UseCase\User\Command\UpdateProfileCommand;
use App\IdentityAndAccess\Application\UseCase\User\CommandHandler\UpdateProfileHandler;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Presentation\Form\UserProfileType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('UserProfileModalFormComponent', template: 'identity_and_access/admin/user/components/profile_modal_form_component.html.twig')]
class UserProfileModalFormComponents extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?UpdateProfileCommand $updateProfileCommand = null;

    public bool $isSuccessful = false;

    public ?string $message = null;

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UpdateProfileHandler    $handler,
    )
    {
    }

    public function mount(string $userId): void
    {
        $profile = $this->repository->getById($userId);
        $this->updateProfileCommand = new UpdateProfileCommand(
            id: $profile->id,
            organization: $profile->getOrganization(),
            name: $profile->getName(),
            email: $profile->getEmail(),
            phone_number: $profile->getPhoneNumber(),
            address: $profile->getAddress(),
        );
    }

    /**
     * @throws Exception
     */
    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();
        /** @var UpdateProfileCommand $command */
        $command = $this->instantiateForm()->getData();
        $this->handler->handle($command);
        $this->isSuccessful = true;
        $this->message = "Votre profil a bien été mise à jour";
    }

    /**
     * @return FormInterface
     */
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(UserProfileType::class, $this->updateProfileCommand);
    }

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }
}