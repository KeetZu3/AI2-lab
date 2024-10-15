<?php

namespace App\Repository;

use App\Entity\Miejscowosc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Miejscowosc>
 *
 * @method Miejscowosc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Miejscowosc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Miejscowosc[]    findAll()
 * @method Miejscowosc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiejscowoscRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Miejscowosc::class);
    }

//    /**
//     * @return Miejscowosc[] Returns an array of Miejscowosc objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Miejscowosc
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
