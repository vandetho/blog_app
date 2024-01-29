<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Blog;
use App\Workflow\Transition\BlogTransition;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * Class BlogEventSubscriber
 * @package App\EventSubscriber
 * @author Vandeth THO <thovandeth@gmail.com>
 */
readonly class BlogEventSubscriber implements EventSubscriberInterface
{
    /**
     * BlogEventSubscriber constructor.
     *
     * @param WorkflowInterface $blogEventStateMachine
     */
    public function __construct(
        // Note: Our workflow is automatically injected with camelCase name
        private WorkflowInterface $blogEventStateMachine
    ){
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.blog_event.enter.checking_content' => 'onCheckingContent',
            // In here, we will prevent the update transition under certain condition
            'workflow.blog_event.guard.update' => 'onGuardUpdate',
        ];
    }

    /**
     * @param Event $event
     * @return void
     */
    public function onCheckingContent(Event $event): void
    {
        /** @var Blog $subject */
        $subject = $event->getSubject();
        if (strlen($subject->getContent()) <= 200) {
            $this->blogEventStateMachine->apply($subject, BlogTransition::INVALID);
            return;
        }
        $this->blogEventStateMachine->apply($subject, BlogTransition::VALID);
    }

    /**
     * @param GuardEvent $event
     * @return void
     */
    public function onGuardUpdate(GuardEvent $event): void
    {
        /** @var Blog $subject */
        $subject = $event->getSubject();
        if (strlen($subject->getContent()) <= 200) {
            $event->setBlocked(true, 'This blog content must have more than 200 characters');
        }
    }
}
