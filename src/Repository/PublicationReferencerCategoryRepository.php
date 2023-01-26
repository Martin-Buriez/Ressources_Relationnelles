<?php

namespace App\Repository;

use App\Entity\PublicationReferencerCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublicationReferencerCategory>
 *
 * @method PublicationReferencerCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationReferencerCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationReferencerCategory[]    findAll()
 * @method PublicationReferencerCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationReferencerCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationReferencerCategory::class);
    }

    public function save(PublicationReferencerCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PublicationReferencerCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PublicationReferencerCategory[] Returns an array of PublicationReferencerCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PublicationReferencerCategory
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
