<?php
declare(strict_types=1);

namespace App\EventListener;

use Psr\Log\LoggerInterface;

/**
 * Class AbstractEventListener
 *
 * @package App\EventListener
 * @author  Vandeth THO <thovandeth@gmail.com>
 */
abstract class AbstractEventListener
{
    public function __construct(
        protected readonly LoggerInterface $logger
    )
    {
    }
}