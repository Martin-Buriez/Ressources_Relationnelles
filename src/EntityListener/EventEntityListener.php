<?php

namespace App\EntityListener;

use App\Entity\Event;
use Doctrine\Common\EventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventEntityListener
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Event $events, EventArgs $event): void
    {
        $events->computeSlug($this->slugger);
    }

    public function preUpdate(Event $events, EventArgs $event): void
    {
        $events->computeSlug($this->slugger);
    }
}