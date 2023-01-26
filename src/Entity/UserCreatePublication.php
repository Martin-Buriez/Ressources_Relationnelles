<?php

namespace App\Entity;

use App\Repository\UserCreatePublicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCreatePublicationRepository::class)]
class UserCreatePublication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCreatePublications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userCreatePublications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Publication $publication = null;

    #[ORM\Column]
    private ?bool $IsCreator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function isIsCreator(): ?bool
    {
        return $this->IsCreator;
    }

    public function setIsCreator(bool $IsCreator): self
    {
        $this->IsCreator = $IsCreator;

        return $this;
    }
}
