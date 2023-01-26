<?php

namespace App\Entity;

use App\Repository\PublicationIncludeImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationIncludeImageRepository::class)]
class PublicationIncludeImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'publicationIncludeImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Publication $publication = null;

    #[ORM\ManyToOne(inversedBy: 'publicationIncludeImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
