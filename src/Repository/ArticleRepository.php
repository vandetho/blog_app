<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ArticleRepository
 * @package App\Repository
 * @author Vandeth THO <thovandeth@gmail.com>
 *
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{

    /**
     * ArticleRepository constructor.
     *
     * @param ManagerRegistry $registry
     * @param string          $dtoClass
     */
    public function __construct(
        ManagerRegistry $registry,
        private readonly string $dtoClass = \App\DTO\Article::class
    ){
        parent::__construct($registry, Article::class);
    }

    /**
     * @return array|\App\DTO\Article[]
     */
    public function findAsDTO(): array
    {
        return $this->createQueryBuilder('a')
            ->select(['a.id', 'a.title', 'a.content', 'a.marking'])
            ->getQuery()
            ->getResult($this->dtoClass);
    }

    /**
     * @param int $id
     * @return \App\DTO\Article|null
     *
     * @throws NonUniqueResultException
     */
    public function findByIdAsDTO(int $id): ?\App\DTO\Article
    {
        return $this->createQueryBuilder('a')
            ->select(['a.id', 'a.title', 'a.content', 'a.marking'])
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult($this->dtoClass);
    }

    /**
     * @return Article
     */
    public function create(): Article
    {
        return new $this->_entityName;
    }

    /**
     * Save an object in the database
     *
     * @param Article $blog
     * @param bool $andFlush tell the manager whether the object needs to be flush or not
     */
    public function save(Article $blog, bool $andFlush = true): void
    {
        $this->persist($blog);
        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * @param Article $blog
     *
     * @return void
     */
    public function persist(Article $blog): void
    {
        $this->getEntityManager()->persist($blog);
    }

    /**
     * @param Article $blog
     * @return void
     */
    public function remove(Article $blog): void
    {
        $this->getEntityManager()->remove($blog);
    }

    /**
     * @param Article $blog
     */
    public function reload(Article $blog): void
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
