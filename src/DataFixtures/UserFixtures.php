<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin1 = new Admin();
        $admin1->setFirstName('Mathieu');
        $admin1->setLastName('Santostefano');

        $password = $this->encoder->encodePassword($admin1, 'password');
        $admin1->setPassword($password);

        $admin1->setEnabled(true);
        $admin1->setEmail('mathieu.santostefano@gmail.com');
        $admin1->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-mathieu', $admin1);
        $manager->persist($admin1);

        $manager->flush();
    }
}
