<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reward = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $plannedDate = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theme $theme = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: UserManageEvent::class, orphanRemoval: true)]
    private Collection $userManageEvents;

    public function __construct()
    {
        $this->userManageEvents = new ArrayCollection();
    }

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

    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(?string $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    public function getPlannedDate(): ?\DateTimeInterface
    {
        return $this->plannedDate;
    }

    public function setPlannedDate(\DateTimeInterface $plannedDate): self
    {
        $this->plannedDate = $plannedDate;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, UserManageEvent>
     */
    public function getUserManageEvents(): Collection
    {
        return $this->userManageEvents;
    }

    public function addUserManageEvent(UserManageEvent $userManageEvent): self
    {
        if (!$this->userManageEvents->contains($userManageEvent)) {
            $this->userManageEvents->add($userManageEvent);
            $userManageEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUserManageEvent(UserManageEvent $userManageEvent): self
    {
        if ($this->userManageEvents->removeElement($userManageEvent)) {
            // set the owning side to null (unless already changed)
            if ($userManageEvent->getEvent() === $this) {
                $userManageEvent->setEvent(null);
            }
        }

        return $this;
    }
}
