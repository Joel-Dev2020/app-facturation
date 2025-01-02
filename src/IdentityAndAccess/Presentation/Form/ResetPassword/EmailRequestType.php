<?php

namespace App\IdentityAndAccess\Presentation\Form\ResetPassword;

use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\EmailRequestCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EmailRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'required' => true,
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Saisissez votre adresse e-mail",
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => "L'adresse email est obligatoire."]),
                new Assert\Email(['message' => "L'adresse email n'est pas valide."]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmailRequestCommand::class,
        ]);
    }
}