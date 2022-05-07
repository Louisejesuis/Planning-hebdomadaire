<?php

namespace App\Repository;

use App\Entity\UserSteps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserSteps>
 *
 * @method UserSteps|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSteps|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSteps[]    findAll()
 * @method UserSteps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStepsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSteps::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserSteps $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UserSteps $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // 
    //  @return UserSteps[] Returns an array of UserSteps objects
    //  
    public function findByUser($user_id)
    {
        $query = $this->createQueryBuilder('us')
            ->andWhere('us.user = :val')
            ->setParameter('val', $user_id)
            ->orderBy('us.id', 'ASC')
            ->getQuery();
        return $query->getResult();

    }
    

    /*
    public function findOneBySomeField($value): ?UserSteps
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
