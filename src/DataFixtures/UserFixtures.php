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

        $password = $this->encoder->encodePassword($admin1, 'wBuscvijTk8Y');
        $admin1->setPassword($password);

        $admin1->setEnabled(true);
        $admin1->setEmail('mathieu.santostefano@gmail.com');
        $admin1->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-mathieu', $admin1);
        $manager->persist($admin1);

        $admin2 = new Admin();
        $admin2->setFirstName('Simon');
        $admin2->setLastName('Gosselin');

        $password = $this->encoder->encodePassword($admin2, 'uaNz9VvceVYL');
        $admin2->setPassword($password);

        $admin2->setEnabled(true);
        $admin2->setEmail('simon.gosselin@gmail.com');
        $admin2->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-simon', $admin2);
        $manager->persist($admin2);

        $manager->flush();
    }
}
