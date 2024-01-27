<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BlogRepository
 * @package App\Repository
 * @author Vandeth THO <thovandeth@gmail.com>
 *
 * @extends ServiceEntityRepository<Blog>
 *
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    /**
     * BlogRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @return Blog
     */
    public function create(): Blog
    {
        return new $this->_entityName;
    }

    /**
     * Save an object in the database
     *
     * @param Blog $blog
     * @param bool $andFlush tell the manager whether the object needs to be flush or not
     */
    public function save(Blog $blog, bool $andFlush = true): void
    {
        $this->persist($blog);
        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * @param Blog $blog
     *
     * @return void
     */
    public function persist(Blog $blog): void
    {
        $this->getEntityManager()->persist($blog);
    }

    /**
     * @param Blog $blog
     * @return void
     */
    public function remove(Blog $blog): void
    {
        $this->getEntityManager()->remove($blog);
    }

    /**
     * @param Blog $blog
     */
    public function reload(Blog $blog): void
    {
        $this->getEntityManager()->refresh($blog);
    }

    /**
     * Flushes all changes to object that have been queued up too now to the database.
     * This effectively synchronizes the in-memory state of managed objects with the
     * database.
     *
     * @return void
     */
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
