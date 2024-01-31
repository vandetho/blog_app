<?php
declare(strict_types=1);

namespace App\Workflow;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Workflow\Transition\ArticleTransition;
use LogicException;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * Class ArticleWorkflowWorkflow
 *
 * @package App\Workflow
 * @author Vandeth THO <thovandeth@gmail.com>
 */
readonly class ArticleWorkflow
{
    /**
     * ArticleWorkflowWorkflow constructor.
     *
     * @param WorkflowInterface $articleWorkflow
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        private WorkflowInterface $articleWorkflow,
        private ArticleRepository    $articleRepository,
    )
    {
    }

    /**
     * Update the article and send it to be reviewed
     *
     * @param string $title
     * @param string $content
     * @return Article
     */
    public function create(string $title, string $content): Article
    {
        $article = $this->articleRepository->create();
        $article->setTitle($title);
        $article->setContent($content);
        $this->articleWorkflow->apply($article, ArticleTransition::CREATE_ARTICLE);
        $this->articleRepository->save($article);
        return $article;
    }

    /**
     * @param int $articleId
     * @return Article
     */
    public function approveContent(int $articleId): Article
    {
        $article = $this->getArticle($articleId);
        $this->articleWorkflow->apply($article, ArticleTransition::APPROVE_CONTENT);
        $this->articleRepository->save($article);
        return $article;

    }

    /**
     * @param int $articleId
     * @return Article
     */
    public function approveSpelling(int $articleId): Article
    {
        $article = $this->getArticle($articleId);
        $this->articleWorkflow->apply($article, ArticleTransition::APPROVE_SPELLING);
        $this->articleRepository->save($article);
        return $article;

    }

    /**
     * Approve the article and publish it
     *
     * @param int $articleId
     * @return Article
     */
    public function publish(int $articleId): Article
    {
        $article = $this->getArticle($articleId);
        $this->articleWorkflow->apply($article, ArticleTransition::PUBLISH);
        $this->articleRepository->save($article);
        return $article;
    }

    private function getArticle(int $articleId): Article
    {
        $article = $this->articleRepository->find($articleId);

        if ($article) {
            return $article;
        }

        throw new LogicException('Article not found');
    }
}
