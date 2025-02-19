<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Workflow\Transition\BlogTransition;
use Symfony\Component\Workflow\Attribute\AsCompletedListener;
use Symfony\Component\Workflow\Event\CompletedEvent;

/**
 * Class TransitionCompletionListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class TransitionCompletionListener extends AbstractEventListener
{
    /**
     * This method is called when the blog transition is completed.
     *
     * @param CompletedEvent $event The event for completing a transition
     *
     * @return void
     */
    #[AsCompletedListener(workflow: 'blog')]
    public function onCompleted(CompletedEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Transition completed from states: $fromState to $toState");
    }

    /**
     * This method is called when the blog transition is completed to the PUBLISH transition.
     *
     * @param CompletedEvent $event The event for completing a transition
     *
     * @return void
     */
    #[AsCompletedListener(workflow: 'blog', transition: BlogTransition::PUBLISH)]
    public function onCompletedPublish(CompletedEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Transition completed from states: $fromState to $toState");
    }
}