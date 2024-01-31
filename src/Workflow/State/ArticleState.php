<?php
declare(strict_types=1);

namespace App\Workflow\State;

/**
 * Class ArticleState
 * @package App\Workflow\State
 * @author Vandeth THO <thovandeth@gmail.com>
 */
final class ArticleState
{
    public const NEW_ARTICLE = 'new_article';
    public const CHECKING_CONTENT = 'checking_content';
    public const CONTENT_APPROVED = 'content_approved';
    public const CHECKING_SPELLING = 'checking_spelling';
    public const SPELLING_APPROVED = 'spelling_approved';
    public const PUBLISHED = 'published';
}
