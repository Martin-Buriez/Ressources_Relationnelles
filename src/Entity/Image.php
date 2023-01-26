<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: PublicationIncludeImage::class, orphanRemoval: true)]
    private Collection $publicationIncludeImages;

    public function __construct()
    {
        $this->publicationIncludeImages = new ArrayCollection();
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
            $publicationIncludeImage->setImage($this);
        }

        return $this;
    }

    public function removePublicationIncludeImage(PublicationIncludeImage $publicationIncludeImage): self
    {
        if ($this->publicationIncludeImages->removeElement($publicationIncludeImage)) {
            // set the owning side to null (unless already changed)
            if ($publicationIncludeImage->getImage() === $this) {
                $publicationIncludeImage->setImage(null);
            }
        }

        return $this;
    }
}
