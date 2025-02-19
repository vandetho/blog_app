<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\Workflow\Attribute\AsAnnounceListener;
use Symfony\Component\Workflow\Event\AnnounceEvent;

/**
 * Class TransitionAnnouncementListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class TransitionAnnouncementListener extends AbstractEventListener
{
    #[AsAnnounceListener]
    public function onAnnounce(AnnounceEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Transition completed from states: $fromState to $toState");
    }
}