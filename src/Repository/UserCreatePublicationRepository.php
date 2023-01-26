<?php

namespace App\Repository;

use App\Entity\UserCreatePublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCreatePublication>
 *
 * @method UserCreatePublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCreatePublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCreatePublication[]    findAll()
 * @method UserCreatePublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCreatePublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCreatePublication::class);
    }

    public function save(UserCreatePublication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserCreatePublication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserCreatePublication[] Returns an array of UserCreatePublication objects
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

//    public function findOneBySomeField($value): ?UserCreatePublication
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
