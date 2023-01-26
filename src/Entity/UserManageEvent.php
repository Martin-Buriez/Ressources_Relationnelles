<?php

namespace App\Entity;

use App\Repository\UserManageEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserManageEventRepository::class)]
class UserManageEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userManageEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'userManageEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\Column]
    private ?bool $IsParticipant = null;

    #[ORM\Column]
    private ?bool $IsOrganizer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function isIsParticipant(): ?bool
    {
        return $this->IsParticipant;
    }

    public function setIsParticipant(bool $IsParticipant): self
    {
        $this->IsParticipant = $IsParticipant;

        return $this;
    }

    public function isIsOrganizer(): ?bool
    {
        return $this->IsOrganizer;
    }

    public function setIsOrganizer(bool $IsOrganizer): self
    {
        $this->IsOrganizer = $IsOrganizer;

        return $this;
    }
}
