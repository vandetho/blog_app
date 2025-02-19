<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Workflow\State\BlogState;
use Symfony\Component\Workflow\Attribute\AsEnteredListener;
use Symfony\Component\Workflow\Event\EnteredEvent;

/**
 * Class StateEnteredListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class StateEnteredListener extends AbstractEventListener
{
    /**
     * This method is called when the blog entered a state.
     *
     * @param EnteredEvent $event The event for entering a state
     * @return void
     */
    #[AsEnteredListener(workflow: 'blog')]
    public function onEntered(EnteredEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }

    /**
     * This method is called when the blog entered the NEED_REVIEW state.
     *
     * @param EnteredEvent $event The event for entering a state
     *
     * @return void
     */
    #[AsEnteredListener(workflow: 'blog', place: BlogState::NEED_REVIEW)]
    public function onEnteredNeedReview(EnteredEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }
}