<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['Commandes', 'Clips', 'Emissions', 'Mashups', 'Courts métrages', 'Séries'] as $k => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $this->addReference('category-' . $k, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
