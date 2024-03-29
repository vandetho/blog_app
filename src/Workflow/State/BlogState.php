<?php
declare(strict_types=1);

namespace App\Workflow\State;

/**
 * Class BlogState
 *
 * @package App\Workflow\State
 * @author Vandeth THO <thovandeth@gmail.com>
 */
final class BlogState
{
    public const NEW_BLOG = 'new_blog';
    public const CHECKING_CONTENT = 'checking_content';
    public const CONTENT_APPROVED = 'content_approved';
    public const CHECKING_SPELLING = 'checking_spelling';
    public const SPELLING_APPROVED = 'spelling_approved';
    public const NEED_REVIEW = 'need_review';
    public const NEED_UPDATE = 'need_update';
    public const PUBLISHED = 'published';
}
