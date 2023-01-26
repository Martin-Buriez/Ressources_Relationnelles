<?php

namespace App\Repository;

use App\Entity\UserCommunicateGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCommunicateGroup>
 *
 * @method UserCommunicateGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCommunicateGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCommunicateGroup[]    findAll()
 * @method UserCommunicateGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCommunicateGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCommunicateGroup::class);
    }

    public function save(UserCommunicateGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserCommunicateGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserCommunicateGroup[] Returns an array of UserCommunicateGroup objects
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

//    public function findOneBySomeField($value): ?UserCommunicateGroup
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
