<?php

namespace App\IdentityAndAccess\Presentation\Form;

use App\IdentityAndAccess\Application\UseCase\User\Command\CreateUserCommand;
use App\IdentityAndAccess\Domain\Service\User\UserRolesService;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function __construct(private readonly Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var SecurityUser $user */
        $user = $this->security->getUser();
        if ($user->isSuperAdmin) {
            $builder->add('organization', TextType::class, [
                'label' => "Raison sociale",
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Raison sociale",
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La raison sociale est obligatoire.']),
                ],
            ]);
        }
        $builder->add('name', TextType::class, [
            'required' => true,
            'label' => "Nom et prénoms",
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Nom et prénoms",
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le nom é prenons est obligatoire.']),
            ],
        ])->add('email', EmailType::class, [
            'required' => true,
            'label' => "Email",
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Email",
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => "L'adresse email est obligatoire."]),
                new Assert\Email(['message' => "L'adresse email n'est pas valide."]),
            ],
        ])->add('phone_number', TextType::class, [
            'required' => true,
            'label' => "Téléphone",
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Téléphone",
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => "Veuillez saisir un numéro de téléphone."]),
            ],
        ])->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passes ne correspondent pas.',
            'help' => 'Le mot de passe doit comporter au minimum 6 caractères',
            'required' => true,
            'first_options' => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmer le mot de passe'],
            'constraints' => [
                new Assert\NotBlank(['message' => "Veuillez saisir un mot de passe."]),
            ],
        ])->add('address', TextareaType::class, [
            'required' => false,
            'label' => "Adresse",
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Adresse ou Situation géographique",
            ]
        ])->add('roles', ChoiceType::class, [
            'multiple' => true,
            'expanded' => true,
            'choices' => $user->isAdmin ? UserRolesService::getAdminListRoles() : UserRolesService::getPrimaryRoles(),
            'data' => match (true) {
                $user->isAdmin => ['ROLE_USER'],
                $user->isSuperAdmin => ['ROLE_ADMIN'],
                default => $user->isAdmin ? ['ROLE_USER'] : ['ROLE_ADMIN'],
            },
            'label' => "Rôle de l'utilisateur",
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(['message' => "Veuillez cocher le rôle svp."]),
            ],
        ])->add('is_enabled', CheckboxType::class, [
            'label' => 'Activer le compte ?',
            'required' => false,
        ]);


        if ($user->isSuperAdmin) {
            $builder->add('is_free', CheckboxType::class, [
                'label' => 'Essai gratuit ?',
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateUserCommand::class,
        ]);
    }
}