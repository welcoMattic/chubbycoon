<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Vos nom et prénom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Le sujet de votre message',
                'choices' => [
                    'Demande de devis' => 'Demande de devis',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Et enfin votre message',
            ])
        ;
    }
}
