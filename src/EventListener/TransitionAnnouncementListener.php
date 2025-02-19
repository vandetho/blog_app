<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Workflow\Transition\BlogTransition;
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
    /**
     * This method is called when the blog is transitioning to a state.
     *
     * @param AnnounceEvent $event The event for announcing a transition
     *
     * @return void
     */
    #[AsAnnounceListener(workflow: 'blog')]
    public function onAnnounce(AnnounceEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Announcing transition from states: $fromState to $toState");
    }

    /**
     * This method is called when the blog is transitioning to the PUBLISH state.
     *
     * @param AnnounceEvent $event The event for announcing a transition
     *
     * @return void
     */
    #[AsAnnounceListener(workflow: 'blog', transition: BlogTransition::PUBLISH)]
    public function onAnnouncePublish(AnnounceEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Announcing transition from states: $fromState to $toState");
    }
}