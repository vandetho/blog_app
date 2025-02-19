<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
     * @param string          $dtoClass
     */
    public function __construct(
        ManagerRegistry $registry,
        private readonly string $dtoClass = \App\DTO\Blog::class
    ){
        parent::__construct($registry, Blog::class);
    }

    /**
     * @return array|\App\DTO\Blog[]
     */
    public function findAsDTO(): array
    {
        return $this->createQueryBuilder('b')
            ->select([
                'b.id',
                'b.title',
                'b.content',
                'b.state',
                'u.id as user_id',
                'u.username as user_username',
            ])
            ->innerJoin('b.user', 'u')
            ->getQuery()
            ->getResult($this->dtoClass);
    }

    /**
     * @param int $id
     * @return \App\DTO\Blog|null
     *
     * @throws NonUniqueResultException
     */
    public function findByIdAsDTO(int $id): ?\App\DTO\Blog
    {
        return $this->createQueryBuilder('b')
            ->select([
                'b.id',
                'b.title',
                'b.content',
                'b.state',
                'u.id as user_id',
                'u.username as user_username',
            ])
            ->innerJoin('b.user', 'u')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult($this->dtoClass);
    }

    /**
     * @return Blog
     */
    public function create(): Blog
    {
        return new Blog();
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
