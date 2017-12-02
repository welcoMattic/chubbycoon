<?php

namespace App\Manager;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var UserPasswordEncoderInterface */
    protected $userPasswordEncoder;

    /**
     * @param $entityManager
     * @param $userPasswordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param $user
     *
     * @return bool
     */
    public function updatePassword(Admin $user)
    {
        if ($user->getPlainPassword()) {
            $password = $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->eraseCredentials();
        }
    }

    /**
     * @param $user
     * @param $flush
     *
     * @return bool
     */
    public function save(UserInterface $user, $flush = true)
    {
        $this->entityManager->persist($user);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function updateUser(UserInterface $user)
    {
        $this->save($user);
    }
}
