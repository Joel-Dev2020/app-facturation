<?php

namespace App\IdentityAndAccess\Presentation\Form;

use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserListQuery;
use App\Service\Constants\AppConstantsService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUserQueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('limit', ChoiceType::class, [
                'choices' => AppConstantsService::DISPLAY_NUMBER,
                'label' => "Affichage par page",
                'required' => true,
                'placeholder' => "Affichage par page",
                'label_attr' => ['class' => 'visually-hidden',],
                'attr' => [
                    'class' => ' form-control'
                ]
            ])->add('organization', TextType::class, [
                'required' => false,
                'label' => "Raison sociale",
                'label_attr' => ['class' => 'visually-hidden',],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Raison sociale",
                ]
            ])->add('name', TextType::class, [
                'required' => false,
                'label' => "Nom & Prénoms",
                'label_attr' => ['class' => 'visually-hidden',],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Nom & Prénoms",
                ]
            ])->add('email', EmailType::class, [
                'required' => false,
                'label' => "Email",
                'label_attr' => ['class' => 'visually-hidden',],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Email",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GetUserListQuery::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}