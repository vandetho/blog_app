<?php
declare(strict_types=1);

namespace App\Tests\Workflow;

use App\Workflow\ArticleWorkflow;
use App\Workflow\State\ArticleState;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ArticleWorkflowTest
 * @package App\Tests\Workflow
 *
 * @author Vandeth THO <thovandeth@gmail.com>
 */
class ArticleWorkflowTest extends KernelTestCase
{
    private ArticleWorkflow $articleWorkflow;

    protected function setUp(): void
    {
        $this->articleWorkflow = self::getContainer()->get(ArticleWorkflow::class);
    }

    public function testCreateArticle(): int
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $article = $this->articleWorkflow->create($title, $content);

        $this->assertNotNull($article->getId());
        $this->assertSame($title, $article->getTitle());
        $this->assertSame($content, $article->getContent());
        $this->assertArrayHasKey(ArticleState::CHECKING_SPELLING, $article->getMarking());
        $this->assertArrayHasKey(ArticleState::CHECKING_CONTENT, $article->getMarking());
        return $article->getId();
    }

    /**
     * @depends testCreateArticle
     */
    public function testApproveContent(int $articleId): void
    {
        $article = $this->articleWorkflow->approveContent($articleId);
        $this->assertArrayHasKey(ArticleState::CONTENT_APPROVED, $article->getMarking());
        $this->assertArrayHasKey(ArticleState::CHECKING_SPELLING, $article->getMarking());
    }

    /**
     * @depends testCreateArticle
     */
    public function testApproveSpelling(int $articleId): void
    {
        $article = $this->articleWorkflow->approveSpelling($articleId);
        $this->assertArrayHasKey(ArticleState::CONTENT_APPROVED, $article->getMarking());
        $this->assertArrayHasKey(ArticleState::SPELLING_APPROVED, $article->getMarking());
    }

    /**
     * @depends testCreateArticle
     */
    public function testPublish(int $articleId): void
    {
        $article = $this->articleWorkflow->publish($articleId);
        $this->assertArrayHasKey(ArticleState::PUBLISHED, $article->getMarking());
    }

}
