<?php

namespace App\EntityListener;

use App\Entity\Publication;
use Doctrine\Common\EventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class PublicationEntityListener
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Publication $publication, EventArgs $event): void
    {
        $publication->computeSlug($this->slugger);
    }

    public function preUpdate(Publication $publication, EventArgs $event): void
    {
        $publication->computeSlug($this->slugger);
    }
}