<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Blog;
use App\Workflow\Transition\BlogTransition;
use Symfony\Component\Workflow\Attribute\AsGuardListener;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class TransitionGuardListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class TransitionGuardListener extends AbstractEventListener
{
    /**
     * This method is called before the transition is applied. In this method, we check if the blog has a title before it is published.
     * It can be used to block the transition.
     *
     * @param GuardEvent $event
     */
    #[AsGuardListener(workflow: 'blog', transition: BlogTransition::PUBLISH)]
    public function onGuardReview(GuardEvent $event): void
    {
        /** @var Blog $blog */
        $blog = $event->getSubject();
        $title = $blog->getTitle();

        if (empty($title)) {
            $event->setBlocked(true, 'This blog cannot be marked as reviewed because it has no title.');
        }
    }
}