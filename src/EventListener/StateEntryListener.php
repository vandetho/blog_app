<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Workflow\State\BlogState;
use Symfony\Component\Workflow\Attribute\AsEnteredListener;
use Symfony\Component\Workflow\Attribute\AsEnterListener;
use Symfony\Component\Workflow\Event\EnteredEvent;
use Symfony\Component\Workflow\Event\EnterEvent;

/**
 * Class StateEntryListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class StateEntryListener extends AbstractEventListener
{
    /**
     * This method is called when the blog entered a state.
     *
     * @param EnterEvent $event The event for entering a state
     * @return void
     */
    #[AsEnterListener(workflow: 'blog')]
    public function onEnter(EnterEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }

    /**
     * This method is called when the blog is entering the NEED_REVIEW state.
     *
     * @param EnterEvent $event The event for entering a state
     *
     * @return void
     */
    #[AsEnterListener(workflow: 'blog', place: BlogState::NEED_REVIEW)]
    public function onEnterNeedReview(EnterEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }
}