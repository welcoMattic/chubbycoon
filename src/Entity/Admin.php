<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"email"}, errorPath="email")
 */
class Admin implements AdvancedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $passwordLastUpdatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $roles = [];

    public function __toString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->passwordLastUpdatedAt = new \DateTime();
        $this->password = $password;
    }

    public function getEncoderName()
    {
        return 'bcrypt';
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     *
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function isPasswordValid(\DateTime $limit)
    {
        if (!$this->passwordLastUpdatedAt) {
            return false;
        }

        return $limit < $this->passwordLastUpdatedAt;
    }

    /**
     * @Assert\Callback()
     */
    public function isPlainPasswordValid(ExecutionContextInterface $context)
    {
        $password = $this->plainPassword;
        if (!$password) {
            return;
        }

        if (!preg_match('{\d}', $password)) {
            $context
                ->buildViolation('validator.password.should_contain_number')
                ->setTranslationDomain('admin')
                ->atPath('plainPassword')
                ->addViolation()
            ;
        }

        if (!preg_match('{[A-Z]}', $password)) {
            $context
                ->buildViolation('validator.password.should_contain_uppercase')
                ->setTranslationDomain('admin')
                ->atPath('plainPassword')
                ->addViolation()
            ;
        }

        if (!preg_match('{[^a-zA-Z0-9]}', $password)) {
            $context
                ->buildViolation('validator.password.should_contain_special_char')
                ->setTranslationDomain('admin')
                ->atPath('plainPassword')
                ->addViolation()
            ;
        }
    }
}
