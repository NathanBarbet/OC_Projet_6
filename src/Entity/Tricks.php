<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Tricks
 *
 * @ORM\Table(name="tricks", indexes={@ORM\Index(name="Groupe_ID", columns={"Groupe_ID"}), @ORM\Index(name="User_ID", columns={"User_ID"})})
 * @ORM\Entity(repositoryClass="App\Repository\TricksRepository")
 */
class Tricks
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
     * @ORM\Column(name="Name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
    * @var string
    * @ORM\column(type="string", length=255, nullable=false)
    */
    private $filename;

    /**
    * @var string|null
    * @ORM\column(type="string", length=255, nullable=false)
    */
    private $imgBackground;

    /**
     * @var string
     * @ORM\column(name="Image_home",type="string", length=255, nullable=false)
     */
    private $imageHome;

    /**
     * @var string
     * @ORM\column(name="Image_background",type="string", length=255, nullable=false)
     */
    private $imageBackground;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_publish", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePublish = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="Date_modify", type="datetime", nullable=true)
     */
    private $dateModify;

    /**
     * @var \Groupe
     *
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Groupe_ID", referencedColumnName="ID")
     * })
     */
    private $groupe;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_ID", referencedColumnName="ID")
     * })
     */
    private $user;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_ID_Modify", referencedColumnName="ID")
     * })
     */
    private $userModify;

    public function __construct()
   {
       $this->datePublish = new \DateTime();
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
        if ($this->name) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        if ($this->description) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        if ($this->filename) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }

    public function getImgBackground(): ?string
    {
        return $this->imgBackground;
    }

    public function setImgBackground(?string $imgBackground): self
    {
        $this->imgBackground = $imgBackground;
        if ($this->imgBackground) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }


    public function getImageHome(): ?File
    {
        return $this->imageHome;
    }

    public function setImageHome(?File $imageHome = null): void
    {
        $this->imageHome = $imageHome;
        if ($this->imageHome instanceof UploadedFile) {
            $this->dateModify = new \DateTime('now');
        }
    }

    public function getImageBackground(): ?File
    {
        return $this->imageBackground;
    }

    public function setImageBackground(?File $imageBackground = null): void
    {
        $this->imageBackground = $imageBackground;
        if ($this->imageBackground instanceof UploadedFile) {
            $this->dateModify = new \DateTime('now');
        }
    }

    public function getDatePublish(): ?\DateTimeInterface
    {
        return $this->datePublish;
    }

    public function setDatePublish(\DateTimeInterface $datePublish): self
    {
        $this->datePublish = $datePublish;

        return $this;
    }

    public function getDateModify(): ?\DateTimeInterface
    {
        return $this->dateModify;
    }

    public function setDateModify(?\DateTimeInterface $dateModify): self
    {
        $this->dateModify = $dateModify;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;
        if ($this->groupe) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserModify(): ?Users
    {
        return $this->userModify;
    }

    public function setUserModify(?Users $userModify): self
    {
        $this->userModify = $userModify;
        if ($this->userModify) {
            $this->dateModify = new \DateTime('now');
        }

        return $this;
    }

}
