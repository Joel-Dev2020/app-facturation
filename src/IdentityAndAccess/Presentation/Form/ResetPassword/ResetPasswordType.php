<?php

namespace App\IdentityAndAccess\Presentation\Form\ResetPassword;

use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\ResetPasswordCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'help' => 'Le mot de passe doit comporter au minimum 6 caractères',
            'required' => true,
            'invalid_message' => 'Les deux mots de passe doivent être identiques.',
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => ['placeholder' => 'Nouveau mot de passe'],
            ],
            'second_options' => [
                'label' => 'Confirmer le mot de passe',
                'attr' => ['placeholder' => 'Confirmer mot de passe'],
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => "Veuillez saisir un nouveau mot de passe."]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResetPasswordCommand::class,
        ]);
    }
}