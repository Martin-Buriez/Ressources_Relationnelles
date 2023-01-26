<?php

namespace App\Entity;

use App\Repository\FilterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilterRepository::class)]
class Filter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'filter', targetEntity: FilterConcernCategory::class, orphanRemoval: true)]
    private Collection $filterConcernCategories;

    #[ORM\OneToMany(mappedBy: 'filter', targetEntity: UserCreateFilter::class, orphanRemoval: true)]
    private Collection $userCreateFilters;

    public function __construct()
    {
        $this->filterConcernCategories = new ArrayCollection();
        $this->userCreateFilters = new ArrayCollection();
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
            $filterConcernCategory->setFilter($this);
        }

        return $this;
    }

    public function removeFilterConcernCategory(FilterConcernCategory $filterConcernCategory): self
    {
        if ($this->filterConcernCategories->removeElement($filterConcernCategory)) {
            // set the owning side to null (unless already changed)
            if ($filterConcernCategory->getFilter() === $this) {
                $filterConcernCategory->setFilter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCreateFilter>
     */
    public function getUserCreateFilters(): Collection
    {
        return $this->userCreateFilters;
    }

    public function addUserCreateFilter(UserCreateFilter $userCreateFilter): self
    {
        if (!$this->userCreateFilters->contains($userCreateFilter)) {
            $this->userCreateFilters->add($userCreateFilter);
            $userCreateFilter->setFilter($this);
        }

        return $this;
    }

    public function removeUserCreateFilter(UserCreateFilter $userCreateFilter): self
    {
        if ($this->userCreateFilters->removeElement($userCreateFilter)) {
            // set the owning side to null (unless already changed)
            if ($userCreateFilter->getFilter() === $this) {
                $userCreateFilter->setFilter(null);
            }
        }

        return $this;
    }
}
