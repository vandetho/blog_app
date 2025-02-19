<?php
declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\Workflow\Attribute\AsEnterListener;
use Symfony\Component\Workflow\Event\EnterEvent;

/**
 * Class StateEntryListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class StateEntryListener extends AbstractEventListener
{
    #[AsEnterListener]
    public function onEnter(EnterEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }
}