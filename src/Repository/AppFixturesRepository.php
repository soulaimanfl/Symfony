<?php

namespace App\Repository;

use App\Entity\AppFixtures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppFixtures>
 *
 * @method AppFixtures|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppFixtures|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppFixtures[]    findAll()
 * @method AppFixtures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppFixturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppFixtures::class);
    }

    //    /**
    //     * @return AppFixtures[] Returns an array of AppFixtures objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AppFixtures
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
