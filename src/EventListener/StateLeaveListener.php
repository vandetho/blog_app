<?php
declare(strict_types=1);

namespace App\EventListener;

use App\EventListener\AbstractEventListener;
use App\Workflow\State\BlogState;
use Symfony\Component\Workflow\Attribute\AsLeaveListener;
use Symfony\Component\Workflow\Event\LeaveEvent;

/**
 * Class StateLeaveListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class StateLeaveListener extends AbstractEventListener
{
    /**
     * This method is called when the blog is leaving a state.
     *
     * @param LeaveEvent $event The event for leaving a state
     *
     * @return void
     */
    #[AsLeaveListener(workflow: 'blog')]
    public function onLeave(LeaveEvent $event): void
    {
        $state = implode(", ", $event->getMarking()->getPlaces());
        $this->logger->info("On leave states: $state");
    }

    /**
     * This method is called when the blog is leaving the NEW_BLOG state.
     *
     * @param LeaveEvent $event The event for leaving a state
     *
     * @return void
     */
    #[AsLeaveListener(workflow: 'blog', place: BlogState::NEW_BLOG)]
    public function onLeaveNewBlog(LeaveEvent $event): void
    {
        $state = implode(", ", $event->getMarking()->getPlaces());
        $this->logger->info("On leave states: $state");
    }

}