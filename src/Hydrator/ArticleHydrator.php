<?php
declare(strict_types=1);


namespace App\Hydrator;

use App\DTO\Article;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ArticleHydrator
 * @package App\Hydrator
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class ArticleHydrator extends AbstractHydrator
{
    /**
     * ArticleHydrator constructor.
     *
     * @param EntityManagerInterface $em
     * @param string $dtoClass
     */
    public function __construct(EntityManagerInterface $em, string $dtoClass = Article::class)
    {
        parent::__construct($em, $dtoClass);
    }
}
