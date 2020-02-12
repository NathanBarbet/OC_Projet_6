<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Medias
 *
 * @ORM\Table(name="medias", indexes={@ORM\Index(name="Tricks_ID", columns={"Tricks_ID"})})
 * @ORM\Entity(repositoryClass="App\Repository\MediasRepository")
 */
class Medias
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
     * @ORM\column(type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @ORM\column(name="Image_medias", type="string", length=255, nullable=false)
     */
    private $imageMedias;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_publish", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePublish = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var \Tricks
     *
     * @ORM\ManyToOne(targetEntity="Tricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Tricks_ID", referencedColumnName="ID")
     * })
     */
    private $tricks;

    public function __construct()
    {
       $this->datePublish = new \DateTime();
    }

    public function __toString()
    {
        return $this->medias;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        if ($this->imageMedias instanceof UploadedFile) {
            $this->datePublish = new \DateTime('now');
        }

        return $this;
    }

    public function getImageMedias(): ?File
    {
        return $this->imageMedias;
    }

    public function setImageMedias(?File $imageMedias = null): void
    {
        $this->imageMedias = $imageMedias;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTricks(): ?Tricks
    {
        return $this->tricks;
        $tricks = $trick->getId();
    }

    public function setTricks(?Tricks $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }


}
