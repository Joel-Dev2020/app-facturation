<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use App\IdentityAndAccess\Domain\Entity\UserReglage;
use App\IdentityAndAccess\Presentation\Form\UserReglageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('UserReglageModalFormComponent', template: 'identity_and_access/admin/user/components/reglage_modal_form_component.html.twig')]
class UserReglageModalFormComponents extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?UserReglage $reglage = null;

    #[LiveProp]
    public bool $isSuccessful = false;

    #[LiveProp(writable: true)]
    public bool $isLoading = false;

    #[LiveProp]
    public ?string $message = null;

    /*public function __construct(private readonly UpdateUserReglageHandler $handler)
    {
    }*/

    public function hasValidationErrors(): bool
    {
        return $this->getForm()->isSubmitted() && !$this->getForm()->isValid();
    }

    #[LiveAction]
    public function save(): void
    {
        $this->isLoading = true;
        $this->isGranted(['ROLE_ADMIN']);
        $this->submitForm();

        /*$reglage = $this->instantiateForm()->getData();
        $action = new UpdateUserReglageAction(
            id: $this->reglage->getId(),
            tva: $reglage->getTva(),
            isDiscount: $reglage->getIsDiscount(),
            prefixNumeroInvoice: $reglage->getPrefixNumeroInvoice(),
        );
        $this->handler->handle($action);*/
        $this->isSuccessful = true;
        $this->message = "Vos reglages ont bien été mise à jour";
        $this->isLoading = false;
    }

    /**
     * @return FormInterface
     */
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(UserReglageType::class, $this->reglage);
    }
}