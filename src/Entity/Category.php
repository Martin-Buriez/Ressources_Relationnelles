<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity('title', 'Une autre ressource porte déjà ce titre')]
#[ApiResource]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le titre de la catégorie est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "Le titre de la catégorie doit être compris entre 10 et 50 caractères")]
    #[Assert\Length(max: 500,maxMessage: "Le titre de la catégorie doit être compris entre 10 et 50 caractères")]
    private ?string $title = null;

    // Relations

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: FilterConcernCategory::class, orphanRemoval: true)]
    private Collection $filterConcernCategories;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Publication::class, orphanRemoval: true)]
    private Collection $publications;

    public function __construct()
    {
        $this->filterConcernCategories = new ArrayCollection();
        $this->publications = new ArrayCollection();
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

    /**
     * @return Collection<int, FilterConcernCategory>
     */
    public function getFilterConcernCategories(): Collection
    {
        return $this->filterConcernCategories;
    }

    public function addFilterConcernCategory(FilterConcernCategory $filterConcernCategory): self
    {
        if (!$this->filterConcernCategories->contains($filterConcernCategory)) {
            $this->filterConcernCategories->add($filterConcernCategory);
            $filterConcernCategory->setCategory($this);
        }

        return $this;
    }

    public function removeFilterConcernCategory(FilterConcernCategory $filterConcernCategory): self
    {
        if ($this->filterConcernCategories->removeElement($filterConcernCategory)) {
            // set the owning side to null (unless already changed)
            if ($filterConcernCategory->getCategory() === $this) {
                $filterConcernCategory->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setCategory($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getCategory() === $this) {
                $publication->setCategory(null);
            }
        }

        return $this;
    }
}
