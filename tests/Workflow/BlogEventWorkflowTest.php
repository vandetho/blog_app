<?php
declare(strict_types=1);

namespace App\Tests\Workflow;

use App\Workflow\BlogEventWorkflow;
use App\Workflow\State\BlogState;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BlogEventWorkflowTest
 * @package App\Tests\Workflow
 *
 * @author Vandeth THO <thovandeth@gmail.com>
 */
class BlogEventWorkflowTest extends KernelTestCase
{
    private BlogEventWorkflow $blogEventWorkflow;

    protected function setUp(): void
    {
        $this->blogEventWorkflow = self::getContainer()->get(BlogEventWorkflow::class);
    }

    public function testCreateValidBlog(): int
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraphs(4, true);
        $blog = $this->blogEventWorkflow->create($title, $content);

        $this->assertNotNull($blog->getId());
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
        return $blog->getId();
    }

    public function testCreateInvalidBlog(): int
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $blog = $this->blogEventWorkflow->create($title, $content);

        $this->assertNotNull($blog->getId());
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_UPDATE, $blog->getState());
        return $blog->getId();
    }

    /**
     * @depends testCreateValidBlog
     */
    public function testReject(int $blogId): void
    {
        $blog = $this->blogEventWorkflow->reject($blogId);
        $this->assertSame(BlogState::NEED_UPDATE, $blog->getState());
    }

    /**
     * @depends testCreateValidBlog
     */
    public function testGuardUpdate(int $blogId): void
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();

        $blog = $this->blogEventWorkflow->update($blogId, $title, $content);
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_UPDATE, $blog->getState());
    }

    /**
     * @depends testGuardUpdate
     */
    public function testUpdate(int $blogId): void
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraphs(4, true);

        $blog = $this->blogEventWorkflow->update($blogId, $title, $content);
        $this->assertSame($title, $blog->getTitle());
        $this->assertSame($content, $blog->getContent());
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
    }

    /**
     * @depends testCreateValidBlog
     */
    public function testPublish(int $blogId): void
    {
        $blog = $this->blogEventWorkflow->publish($blogId);
        $this->assertSame(BlogState::PUBLISHED, $blog->getState());
    }

    /**
     * @depends testCreateValidBlog
     */
    public function testNeedReview(int $blogId): void
    {
        $blog = $this->blogEventWorkflow->needReview($blogId);
        $this->assertSame(BlogState::NEED_REVIEW, $blog->getState());
    }
}
