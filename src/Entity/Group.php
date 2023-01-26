<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: UserBelongGroup::class, orphanRemoval: true)]
    private Collection $userBelongGroups;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: UserCommunicateGroup::class, orphanRemoval: true)]
    private Collection $userCommunicateGroups;

    public function __construct()
    {
        $this->userBelongGroups = new ArrayCollection();
        $this->userCommunicateGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, UserBelongGroup>
     */
    public function getUserBelongGroups(): Collection
    {
        return $this->userBelongGroups;
    }

    public function addUserBelongGroup(UserBelongGroup $userBelongGroup): self
    {
        if (!$this->userBelongGroups->contains($userBelongGroup)) {
            $this->userBelongGroups->add($userBelongGroup);
            $userBelongGroup->setGroupe($this);
        }

        return $this;
    }

    public function removeUserBelongGroup(UserBelongGroup $userBelongGroup): self
    {
        if ($this->userBelongGroups->removeElement($userBelongGroup)) {
            // set the owning side to null (unless already changed)
            if ($userBelongGroup->getGroupe() === $this) {
                $userBelongGroup->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCommunicateGroup>
     */
    public function getUserCommunicateGroups(): Collection
    {
        return $this->userCommunicateGroups;
    }

    public function addUserCommunicateGroup(UserCommunicateGroup $userCommunicateGroup): self
    {
        if (!$this->userCommunicateGroups->contains($userCommunicateGroup)) {
            $this->userCommunicateGroups->add($userCommunicateGroup);
            $userCommunicateGroup->setGroupe($this);
        }

        return $this;
    }

    public function removeUserCommunicateGroup(UserCommunicateGroup $userCommunicateGroup): self
    {
        if ($this->userCommunicateGroups->removeElement($userCommunicateGroup)) {
            // set the owning side to null (unless already changed)
            if ($userCommunicateGroup->getGroupe() === $this) {
                $userCommunicateGroup->setGroupe(null);
            }
        }

        return $this;
    }
}
