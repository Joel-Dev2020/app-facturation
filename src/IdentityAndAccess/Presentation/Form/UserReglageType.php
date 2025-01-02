<?php

namespace App\IdentityAndAccess\Presentation\Form;

use App\IdentityAndAccess\Domain\Entity\UserReglage;
use App\SharedKernel\Domain\Entity\Devise\Devise;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserReglageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tva', IntegerType::class, [
                'label' => 'Tva',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Valeur de la tva',
                    'class' => 'form-control',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Adresse email',
                    'class' => 'form-control',
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'form-control',
                ]
            ])
            ->add('prefixNumeroInvoice', TextType::class, [
                'label' => 'Prefix des numéro de facture',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prefix des numéro de facture',
                    'class' => 'form-control',
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'form-control',
                    'rows' => 3,
                ]
            ])->add('devises', EntityType::class, [
                'class' => Devise::class,
                'choice_label' => 'currencyName',
                'placeholder' => 'Choisir une devise',
                'required' => false,
                'autocomplete' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->where('d.is_active = :active')
                        ->setParameter('active', true)
                        ->orderBy('d.currencyName', 'ASC');
                },
            ])
            ->add('isRemise', CheckboxType::class, [
                'label' => 'Appliquer les remises ?',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserReglage::class
        ]);
    }
}