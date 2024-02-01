<?php
declare(strict_types=1);


namespace App\Hydrator;

use App\DTO\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserHydrator
 * @package App\Hydrator
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
class UserHydrator extends AbstractHydrator
{
    /**
     * UserHydrator constructor.
     *
     * @param EntityManagerInterface $em
     * @param string $dtoClass
     */
    public function __construct(EntityManagerInterface $em, string $dtoClass = User::class)
    {
        parent::__construct($em, $dtoClass);
    }
}
