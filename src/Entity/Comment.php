<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
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

    #[ORM\Column]
    private ?bool $reportedStatus = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: UserEditComment::class, orphanRemoval: true)]
    private Collection $userEditComments;

    public function __construct()
    {
        $this->userEditComments = new ArrayCollection();
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

    public function isReportedStatus(): ?bool
    {
        return $this->reportedStatus;
    }

    public function setReportedStatus(bool $reportedStatus): self
    {
        $this->reportedStatus = $reportedStatus;

        return $this;
    }

    /**
     * @return Collection<int, UserEditComment>
     */
    public function getUserEditComments(): Collection
    {
        return $this->userEditComments;
    }

    public function addUserEditComment(UserEditComment $userEditComment): self
    {
        if (!$this->userEditComments->contains($userEditComment)) {
            $this->userEditComments->add($userEditComment);
            $userEditComment->setComment($this);
        }

        return $this;
    }

    public function removeUserEditComment(UserEditComment $userEditComment): self
    {
        if ($this->userEditComments->removeElement($userEditComment)) {
            // set the owning side to null (unless already changed)
            if ($userEditComment->getComment() === $this) {
                $userEditComment->setComment(null);
            }
        }

        return $this;
    }
}
