<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface,\Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Firstname", type="string", length=40, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=40, nullable=false)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_register", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateRegister = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="Avatar", type="string", length=50, nullable=false)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=500, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="Admin", type="boolean", nullable=false)
     */
    private $admin;

    /**
     * @var string
     *
     * @ORM\Column(name="Token", type="string", length=40, nullable=false)
     */
    private $token;

    /**
     * @ORM\Column(name="isActive", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @ORM\Column(name="isValide", type="boolean", nullable=false)
     */
    private $isValide;

    public function __construct()
    {
        $this->dateRegister = new \DateTime();
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->username;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateRegister(): ?\DateTimeInterface
    {
        return $this->dateRegister;
    }

    public function setDateRegister(\DateTimeInterface $dateRegister): self
    {
        $this->dateRegister = $dateRegister;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIsValide(): ?bool
    {
        return $this->isValide;
    }

    public function setIsValide(bool $isValide): self
    {
        $this->isValide = $isValide;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getUsername()
    {
      return $this->email;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize ([
           $this->id,
           $this->name,
           $this->firstname,
           $this->email,
           $this->admin,
           $this->isActive,
           $this->isValide,
           $this->password,
       ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
           $this->id,
           $this->name,
           $this->firstname,
           $this->email,
           $this->admin,
           $this->isActive,
           $this->isValide,
           $this->password,

       ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function __toString()
    {
        return $this->name;
    }
}
