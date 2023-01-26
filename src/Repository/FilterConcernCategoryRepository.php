<?php

namespace App\Repository;

use App\Entity\FilterConcernCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FilterConcernCategory>
 *
 * @method FilterConcernCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilterConcernCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilterConcernCategory[]    findAll()
 * @method FilterConcernCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilterConcernCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilterConcernCategory::class);
    }

    public function save(FilterConcernCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FilterConcernCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FilterConcernCategory[] Returns an array of FilterConcernCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FilterConcernCategory
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
