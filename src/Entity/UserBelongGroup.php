<?php

namespace App\Entity;

use App\Repository\UserBelongGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBelongGroupRepository::class)]
class UserBelongGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBelongGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userBelongGroups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $groupe = null;

    #[ORM\Column]
    private ?bool $IsSupervisor = null;

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

    public function getGroupe(): ?Group
    {
        return $this->groupe;
    }

    public function setGroupe(?Group $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function isIsSupervisor(): ?bool
    {
        return $this->IsSupervisor;
    }

    public function setIsSupervisor(bool $IsSupervisor): self
    {
        $this->IsSupervisor = $IsSupervisor;

        return $this;
    }
}
