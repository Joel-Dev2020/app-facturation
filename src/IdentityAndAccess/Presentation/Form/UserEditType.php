<?php

namespace App\IdentityAndAccess\Presentation\Form;

use App\IdentityAndAccess\Application\UseCase\User\Command\UpdateUserCommand;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditType extends AbstractType
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
                'required' => true,
                'label' => "Raison sociale",
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
        ])->add('email', TextType::class, [
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
        ])->add('address', TextareaType::class, [
            'required' => false,
            'label' => "Adresse",
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Adresse ou Situation géographique",
            ]
        ])->add('enabled', CheckboxType::class, [
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
            'data_class' => UpdateUserCommand::class,
        ]);
    }
}