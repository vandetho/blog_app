<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User
     */
    public function create(): User
    {
        return new $this->_entityName;
    }

    /**
     * Save an object in the database
     *
     * @param User $blog
     * @param bool $andFlush tell the manager whether the object needs to be flush or not
     */
    public function save(User $blog, bool $andFlush = true): void
    {
        $this->persist($blog);
        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * @param User $blog
     *
     * @return void
     */
    public function persist(User $blog): void
    {
        $this->getEntityManager()->persist($blog);
    }

    /**
     * @param User $blog
     * @return void
     */
    public function remove(User $blog): void
    {
        $this->getEntityManager()->remove($blog);
    }

    /**
     * @param User $blog
     */
    public function reload(User $blog): void
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
