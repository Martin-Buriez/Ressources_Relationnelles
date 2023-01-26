<?php

namespace App\Repository;

use App\Entity\PublicationIncludeImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PublicationIncludeImage>
 *
 * @method PublicationIncludeImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationIncludeImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationIncludeImage[]    findAll()
 * @method PublicationIncludeImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationIncludeImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicationIncludeImage::class);
    }

    public function save(PublicationIncludeImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PublicationIncludeImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PublicationIncludeImage[] Returns an array of PublicationIncludeImage objects
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

//    public function findOneBySomeField($value): ?PublicationIncludeImage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
