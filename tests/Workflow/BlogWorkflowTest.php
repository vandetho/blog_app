<?php
declare(strict_types=1);

namespace App\Tests\Workflow;

use App\Workflow\BlogWorkflow;
use App\Workflow\State\BlogState;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BlogWorkflowTest
 * @package App\Tests\Workflow
 *
 * @author Vandeth THO <thovandeth@gmail.com>
 */
class BlogWorkflowTest extends KernelTestCase
{
    private BlogWorkflow $blogWorkflow;

    protected function setUp(): void
    {
        $this->blogWorkflow = self::getContainer()->get(BlogWorkflow::class);
    }

    public function testCreateBlog(): int
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $blog = $this->blogWorkflow->create($title, $content);

        $this->assertNotNull($blog->getId());
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
        return $blog->getId();
    }

    /**
     * @depends testCreateBlog
     */
    public function testReject(int $blogId): void
    {
        $blog = $this->blogWorkflow->reject($blogId);
        $this->assertSame(BlogState::NEED_UPDATE, $blog->getState());
    }

    /**
     * @depends testCreateBlog
     */
    public function testUpdate(int $blogId): void
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();

        $blog = $this->blogWorkflow->update($blogId, $title, $content);
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
    }

    /**
     * @depends testCreateBlog
     */
    public function testPublish(int $blogId): void
    {
        $blog = $this->blogWorkflow->publish($blogId);
        $this->assertSame(BlogState::PUBLISHED, $blog->getState());
    }

    /**
     * @depends testCreateBlog
     */
    public function testNeedReview(int $blogId): void
    {
        $blog = $this->blogWorkflow->needReview($blogId);
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
    }
}
