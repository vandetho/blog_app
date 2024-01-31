<?php
declare(strict_types=1);

namespace App\Workflow\Transition;

/**
 * Class ArticleTransition
 * @package App\Workflow\Transition
 * @author Vandeth THO <thovandeth@gmail.com>
 */
final class ArticleTransition
{
    public const CREATE_ARTICLE = 'create_article';
    public const PUBLISH = 'publish';
    public const APPROVE_CONTENT = 'approve_content';
    public const APPROVE_SPELLING = 'approve_spelling';
}
