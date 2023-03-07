<?php

namespace App\Entity;

use App\Repository\UserCommunicateGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCommunicateGroupRepository::class)]
class UserCommunicateGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCommunicateGroups')]
    // #[ORM\JoinColumn(nullable: false)]
    private ?Group $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'userCommunicateGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userSendMessage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Group
    {
        return $this->groupe;
    }

    public function setGroupe(?Group $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getUserSendMessage(): ?User
    {
        return $this->userSendMessage;
    }

    public function setUserSendMessage(?User $userSendMessage): self
    {
        $this->userSendMessage = $userSendMessage;

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
