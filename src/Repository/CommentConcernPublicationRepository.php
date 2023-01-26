<?php

namespace App\Repository;

use App\Entity\CommentConcernPublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentConcernPublication>
 *
 * @method CommentConcernPublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentConcernPublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentConcernPublication[]    findAll()
 * @method CommentConcernPublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentConcernPublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentConcernPublication::class);
    }

    public function save(CommentConcernPublication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommentConcernPublication $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CommentConcernPublication[] Returns an array of CommentConcernPublication objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommentConcernPublication
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
