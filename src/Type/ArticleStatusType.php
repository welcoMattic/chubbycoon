<?php

namespace App\Type;

use App\Enum\ArticleStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleStatusType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Non publié' => ArticleStatus::UNPUBLISHED,
                'Publié' => ArticleStatus::PUBLISHED,
            ],
            'expanded' => true,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
