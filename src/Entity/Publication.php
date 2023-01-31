<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
#[ApiResource]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le titre de la publication est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "Le titre de la publication doit être compris entre 10 et 50 caractères")]
    #[Assert\Length(max: 500,maxMessage: "Le titre de la publication doit être compris entre 10 et 50 caractères")]
    private ?string $title = null;

    #[ORM\Column(length: 5000)]
    #[Assert\NotBlank(message: "Le titre de la publication est obligatoire")]
    #[Assert\Length(min: 50,minMessage: "Le titre de la publication doit être compris entre 50 et 5000 caractères")]
    #[Assert\Length(max: 5000,maxMessage: "Le titre de la publication doit être compris entre 50 et 5000 caractères")]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'état ( Validée ou non ) de la publication est obligatoire")]
    private ?bool $state_validated = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'état ( Privée ou non ) de la publication est obligatoire")]
    private ?bool $state_private = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nombre de like de la publication est obligatoire")]
    private ?int $like_number = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nombre de partage de la publication est obligatoire")]
    private ?int $sharing_number = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nombre de vues de la publication est obligatoire")]
    private ?int $view_number = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La date de création de la publication est obligatoire")]
    private ?\DateTime $created_at = null;

    // Relations

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La publication doit obligatoirement posséder un créateur")]
    private ?User $created_by = null;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La publication doit obligatoirement être liée à un thème")]
    private ?Theme $theme = null;

    // To do

    #[ORM\OneToMany(mappedBy: 'publication', targetEntity: CommentConcernPublication::class, orphanRemoval: true)]
    private Collection $commentConcernPublications;

    #[ORM\OneToMany(mappedBy: 'publication', targetEntity: PublicationIncludeImage::class, orphanRemoval: true)]
    private Collection $publicationIncludeImages;

    #[ORM\OneToMany(mappedBy: 'publication', targetEntity: PublicationReferencerCategory::class, orphanRemoval: true)]
    private Collection $publicationReferencerCategories;

    // Gets & Setters

    public function __construct()
    {
        $this->commentConcernPublications = new ArrayCollection();
        $this->publicationIncludeImages = new ArrayCollection();
        $this->publicationReferencerCategories = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isStateValidated(): ?bool
    {
        return $this->state_validated;
    }

    public function setStateValidated(bool $state_validated): self
    {
        $this->state_validated = $state_validated;

        return $this;
    }

    public function isStatePrivate(): ?bool
    {
        return $this->state_private;
    }

    public function setStatePrivate(bool $state_private): self
    {
        $this->state_private = $state_private;

        return $this;
    }

    public function getLikeNumber(): ?int
    {
        return $this->like_number;
    }

    public function setLikeNumber(int $like_number): self
    {
        $this->like_number = $like_number;

        return $this;
    }

    public function getSharingNumber(): ?int
    {
        return $this->sharing_number;
    }

    public function setSharingNumber(int $sharing_number): self
    {
        $this->sharing_number = $sharing_number;

        return $this;
    }

    public function getViewNumber(): ?int
    {
        return $this->view_number;
    }

    public function setViewNumber(int $view_number): self
    {
        $this->view_number = $view_number;

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
     * @return Collection<int, CommentConcernPublication>
     */
    public function getCommentConcernPublications(): Collection
    {
        return $this->commentConcernPublications;
    }

    public function addCommentConcernPublication(CommentConcernPublication $commentConcernPublication): self
    {
        if (!$this->commentConcernPublications->contains($commentConcernPublication)) {
            $this->commentConcernPublications->add($commentConcernPublication);
            $commentConcernPublication->setPublication($this);
        }

        return $this;
    }

    public function removeCommentConcernPublication(CommentConcernPublication $commentConcernPublication): self
    {
        if ($this->commentConcernPublications->removeElement($commentConcernPublication)) {
            // set the owning side to null (unless already changed)
            if ($commentConcernPublication->getPublication() === $this) {
                $commentConcernPublication->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCreatePublication>
     */
    public function getUserCreatePublications(): Collection
    {
        return $this->userCreatePublications;
    }

    public function addUserCreatePublication(UserCreatePublication $userCreatePublication): self
    {
        if (!$this->userCreatePublications->contains($userCreatePublication)) {
            $this->userCreatePublications->add($userCreatePublication);
            $userCreatePublication->setPublication($this);
        }

        return $this;
    }

    public function removeUserCreatePublication(UserCreatePublication $userCreatePublication): self
    {
        if ($this->userCreatePublications->removeElement($userCreatePublication)) {
            // set the owning side to null (unless already changed)
            if ($userCreatePublication->getPublication() === $this) {
                $userCreatePublication->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PublicationIncludeImage>
     */
    public function getPublicationIncludeImages(): Collection
    {
        return $this->publicationIncludeImages;
    }

    public function addPublicationIncludeImage(PublicationIncludeImage $publicationIncludeImage): self
    {
        if (!$this->publicationIncludeImages->contains($publicationIncludeImage)) {
            $this->publicationIncludeImages->add($publicationIncludeImage);
            $publicationIncludeImage->setPublication($this);
        }

        return $this;
    }

    public function removePublicationIncludeImage(PublicationIncludeImage $publicationIncludeImage): self
    {
        if ($this->publicationIncludeImages->removeElement($publicationIncludeImage)) {
            // set the owning side to null (unless already changed)
            if ($publicationIncludeImage->getPublication() === $this) {
                $publicationIncludeImage->setPublication(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PublicationReferencerCategory>
     */
    public function getPublicationReferencerCategories(): Collection
    {
        return $this->publicationReferencerCategories;
    }

    public function addPublicationReferencerCategory(PublicationReferencerCategory $publicationReferencerCategory): self
    {
        if (!$this->publicationReferencerCategories->contains($publicationReferencerCategory)) {
            $this->publicationReferencerCategories->add($publicationReferencerCategory);
            $publicationReferencerCategory->setPublication($this);
        }

        return $this;
    }

    public function removePublicationReferencerCategory(PublicationReferencerCategory $publicationReferencerCategory): self
    {
        if ($this->publicationReferencerCategories->removeElement($publicationReferencerCategory)) {
            // set the owning side to null (unless already changed)
            if ($publicationReferencerCategory->getPublication() === $this) {
                $publicationReferencerCategory->setPublication(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }
}
