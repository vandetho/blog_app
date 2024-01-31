<?php
declare(strict_types=1);

namespace App\DTO;

/**
 * Class Blog
 * @package App\DTO
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class Article
{

    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $content = null;

    /**
     * @var array|null
     */
    public ?array $marking = null;
}
