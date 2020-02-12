<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="Tricks_ID", columns={"Tricks_ID"}), @ORM\Index(name="User_ID", columns={"User_ID"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
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
     * @ORM\Column(name="Content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_publish", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datePublish = 'CURRENT_TIMESTAMP';

    /**
     * @var \Tricks
     *
     * @ORM\ManyToOne(targetEntity="Tricks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Tricks_ID", referencedColumnName="ID")
     * })
     */
    private $tricks;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_ID", referencedColumnName="ID")
     * })
     */
    private $user;

    public function __construct()
   {
       $this->datePublish = new \DateTime();
   }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getTricks(): ?Tricks
    {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): self
    {
        $this->tricks = $tricks;

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


}
