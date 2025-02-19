<?php
declare(strict_types=1);

namespace App\EventListener;

use App\EventListener\AbstractEventListener;
use App\Workflow\Transition\BlogTransition;
use Symfony\Component\Workflow\Attribute\AsTransitionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

/**
 * Class TransitionListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class TransitionListener extends AbstractEventListener
{
    /**
     * This method is called when the blog is transitioning to a state.
     *
     * @param TransitionEvent $event The event for transitioning a state
     * @return void
     */
    #[AsTransitionListener(workflow: 'blog')]
    public function onTransition(TransitionEvent $event): void
    {
        $state = implode(", ", $event->getMarking()->getPlaces());
        $this->logger->info("On transition states: $state");
    }

    /**
     * This method is called when the blog is transitioning to the PUBLISH state.
     *
     * @param TransitionEvent $event The event for transitioning a state
     * @return void
     */
    #[AsTransitionListener(workflow: 'blog', transition: BlogTransition::PUBLISH)]
    public function onTransitionPublish(TransitionEvent $event): void
    {
        $state = implode(", ", $event->getMarking()->getPlaces());
        $this->logger->info("On transition states: $state");
    }
}