<?php
declare(strict_types=1);

namespace App\DTO;

/**
 * Class Blog
 * @package App\DTO
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class Blog
{
    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $content = null;
}