<?php
declare(strict_types=1);

namespace App\EventListener;

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
    #[AsEnteredListener]
    public function onEntered(EnteredEvent $event): void
    {
        $transition = $event->getTransition();
        $states = implode(", ", $transition->getFroms());
        $this->logger->info("On enter states: $states");
    }
}