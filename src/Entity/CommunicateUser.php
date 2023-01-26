<?php

namespace App\Entity;

use App\Repository\CommunicateUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommunicateUserRepository::class)]
class CommunicateUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'communicateUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userSender = null;

    #[ORM\ManyToOne(inversedBy: 'communicateUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userReceive = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
