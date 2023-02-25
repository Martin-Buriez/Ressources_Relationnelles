<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserRelationship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserRelationship>
 *
 * @method UserRelationship|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRelationship|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRelationship[]    findAll()
 * @method UserRelationship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRelationshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRelationship::class);
    }

    public function save(UserRelationship $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserRelationship $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findUserRelationship(User $userSender, User $userReceive): ?UserRelationship
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.userSender = :userSender')
            ->setParameter('userSender', $userSender)
            ->andWhere('u.userReceive = :userReceive')
            ->setParameter('userReceive', $userReceive)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return UserRelationship[] Returns an array of UserRelationship objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserRelationship
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
