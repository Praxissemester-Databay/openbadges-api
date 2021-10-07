<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AssignmentRepository::class)
 */
class Assignment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Badge::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $badge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $narrative;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $issuedOn;

    /**
     * @ORM\ManyToOne(targetEntity=Recipient::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBadge(): ?Badge
    {
        return $this->badge;
    }

    public function setBadge(Badge $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNarrative(): ?string
    {
        return $this->narrative;
    }

    public function setNarrative(?string $narrative): self
    {
        $this->narrative = $narrative;

        return $this;
    }

    public function getIssuedOn(): ?\DateTimeInterface
    {
        return $this->issuedOn;
    }

    public function setIssuedOn(?\DateTimeInterface $issuedOn): self
    {
        $this->issuedOn = $issuedOn;

        return $this;
    }

    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(?Recipient $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }
}
