<?php
declare(strict_types=1);

namespace App\Workflow;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Workflow\Transition\BlogTransition;
use LogicException;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * Class BlogWorkflow
 *
 * @package App\Workflow
 * @author Vandeth THO <thovandeth@gmail.com>
 */
readonly class BlogWorkflow
{
    /**
     * BlogWorkflow constructor.
     *
     * @param WorkflowInterface $blogStateMachine
     * @param BlogRepository $blogRepository
     */
    public function __construct(
        private WorkflowInterface $blogStateMachine,
        private BlogRepository    $blogRepository,
    )
    {
    }

    /**
     * Update the blog and send it to be reviewed
     *
     * @param string $title
     * @param string $content
     * @return Blog
     */
    public function create(string $title, string $content): Blog
    {
        $blog = $this->blogRepository->create();
        $blog->setTitle($title);
        $blog->setContent($content);
        $this->blogStateMachine->apply($blog, BlogTransition::CREATE_BLOG);
        $this->blogRepository->save($blog);
        return $blog;
    }

    /**
     * Reject the blog and send it to be updated
     *
     * @param int $blogId
     * @return Blog
     */
    public function reject(int $blogId): Blog
    {
        $blog = $this->getBlog($blogId);
        $this->blogStateMachine->apply($blog, BlogTransition::REJECT);
        $this->blogRepository->save($blog);
        return $blog;

    }

    /**
     * Update the blog and send it to be reviewed
     *
     * @param int $blogId
     * @param string|null $title
     * @param string|null $content
     * @return Blog
     */
    public function update(int $blogId, ?string $title, ?string $content): Blog
    {
        $blog = $this->getBlog($blogId);
        if ($title) {
            $blog->setTitle($title);
        }
        if ($content) {
            $blog->setContent($content);
        }
        $this->blogStateMachine->apply($blog, BlogTransition::UPDATE);
        $this->blogRepository->save($blog);
        return $blog;
    }

    /**
     * Approve the blog and publish it
     *
     * @param int $blogId
     * @return Blog
     */
    public function publish(int $blogId): Blog
    {
        $blog = $this->getBlog($blogId);
        $this->blogStateMachine->apply($blog, BlogTransition::PUBLISH);
        $this->blogRepository->save($blog);
        return $blog;
    }

    /**
     * Reject the blog and send it to be updated
     *
     * @param int $blogId
     * @return Blog
     */
    public function needReview(int $blogId): Blog
    {
        $blog = $this->getBlog($blogId);
        $this->blogStateMachine->apply($blog, BlogTransition::NEED_REVIEW);
        $this->blogRepository->save($blog);
        return $blog;
    }

    private function getBlog(int $blogId): Blog
    {
        $blog = $this->blogRepository->find($blogId);

        if ($blog) {
            return $blog;
        }

        throw new LogicException('Blog not found');
    }
}
