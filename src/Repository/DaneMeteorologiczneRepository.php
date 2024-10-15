<?php

namespace App\Repository;

use App\Entity\DaneMeteorologiczne;
use App\Entity\Miejscowosc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DaneMeteorologiczne>
 *
 * @method DaneMeteorologiczne|null find($id, $lockMode = null, $lockVersion = null)
 * @method DaneMeteorologiczne|null findOneBy(array $criteria, array $orderBy = null)
 * @method DaneMeteorologiczne[]    findAll()
 * @method DaneMeteorologiczne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DaneMeteorologiczneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DaneMeteorologiczne::class);
    }

//    /**
//     * @return DaneMeteorologiczne[] Returns an array of DaneMeteorologiczne objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DaneMeteorologiczne
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByLocation(Miejscowosc $miejscowosc)
    {
        $qb = $this->createQueryBuilder('dm');
        $qb->where('dm.location = :miejscowosc')
            ->setParameter('miejscowosc', $miejscowosc)
            ->andWhere('dm.data_pomiaru > :now')
            ->setParameter('now', date('Y-m-d'));

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }



}
