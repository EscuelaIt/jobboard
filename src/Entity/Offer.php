<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OfferType", inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $compensation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->Company;
    }

    public function setCompany(?Company $Company): self
    {
        $this->Company = $Company;

        return $this;
    }

    public function getType(): ?OfferType
    {
        return $this->type;
    }

    public function setType(?OfferType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCompensation()
    {
        return $this->compensation;
    }

    public function setCompensation($compensation): self
    {
        $this->compensation = $compensation;

        return $this;
    }
}
