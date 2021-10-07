<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RecipientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RecipientRepository::class)
 */
class Recipient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hashed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $salt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHashed(): ?bool
    {
        return $this->hashed;
    }

    public function setHashed(?bool $hashed): self
    {
        $this->hashed = $hashed;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(?string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }
}
