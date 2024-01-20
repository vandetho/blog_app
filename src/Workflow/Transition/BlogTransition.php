<?php
declare(strict_types=1);

namespace App\Workflow\Transition;

/**
 * Class BlogTransition
 *
 * @package App\Workflow\Transition
 * @author Vandeth THO <thovandeth@gmail.com>
 */
final class BlogTransition
{
    public const CREATE_BLOG = 'create_blog';
    public const UPDATE = 'update';
    public const PUBLISH = 'publish';
    public const REJECT = 'reject';
    public const NEED_REVIEW = 'need_review';
}
