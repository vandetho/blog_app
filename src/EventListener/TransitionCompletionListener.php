<?php
declare(strict_types=1);

namespace App\EventListener;

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
    #[AsCompletedListener]
    public function onCompleted(CompletedEvent $event): void
    {
        $transition = $event->getTransition();
        $fromState = implode(", ", $transition->getFroms());
        $toState = implode(", ", $transition->getFroms());
        $this->logger->info("Transition completed from states: $fromState to $toState");
    }
}