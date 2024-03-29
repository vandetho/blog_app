<?php
declare(strict_types=1);


namespace App\Hydrator;

use App\DTO\Blog;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BlogHydrator
 * @package App\Hydrator
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class BlogHydrator extends AbstractHydrator
{
    /**
     * BlogHydrator constructor.
     *
     * @param EntityManagerInterface $em
     * @param string $dtoClass
     */
    public function __construct(EntityManagerInterface $em, string $dtoClass = Blog::class)
    {
        parent::__construct($em, $dtoClass);
    }
}
