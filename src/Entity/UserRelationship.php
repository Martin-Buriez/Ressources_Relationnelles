<?php

namespace App\Entity;

use App\Repository\UserRelationshipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRelationshipRepository::class)]
class UserRelationship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userRelationships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userSender = null;

    #[ORM\ManyToOne(inversedBy: 'userRelationships')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userReceive = null;

    #[ORM\Column]
    private ?bool $state = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserSender(): ?User
    {
        return $this->userSender;
    }

    public function setUserSender(?User $userSender): self
    {
        $this->userSender = $userSender;

        return $this;
    }

    public function getUserReceive(): ?User
    {
        return $this->userReceive;
    }

    public function setUserReceive(?User $userReceive): self
    {
        $this->userReceive = $userReceive;

        return $this;
    }

    public function isState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
