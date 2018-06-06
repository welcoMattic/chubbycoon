<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findRelatedArticles(Category $category): array
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.category = :category')
            ->setParameter('category', $category)
            ->setMaxResults('5')
        ;

        return $qb->getQuery()->getResult();
    }
}
