<?php

namespace App\Controller;

use App\Manager\UserManager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function prePersistAdminEntity($admin)
    {
        $this->userManager->updatePassword($admin);
    }

    public function preUpdateAdminEntity($admin)
    {
        $this->userManager->updatePassword($admin);
    }
}
