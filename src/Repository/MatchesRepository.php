<?php

namespace App\Repository;

use App\Entity\Matches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matches>
 *
 * @method Matches|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matches|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matches[]    findAll()
 * @method Matches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matches::class);
    }

    public function save(Matches $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Matches $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllMatchs(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getNextMatch(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('m.date_heure', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllAfterMatch(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure < :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('m.date_heure', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllBeforeMatch(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('m.date_heure', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMatchById(int $id): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMatchByDate(\DateTime $date): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMatchByDateAfter(\DateTime $date): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure > :date')
            ->setParameter('date', $date)
            ->orderBy('m.date_heure', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMatchByDateBefore(\DateTime $date): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure < :date')
            ->setParameter('date', $date)
            ->orderBy('m.date_heure', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMatchByDateBetween(\DateTime $date1, \DateTime $date2): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.date_heure BETWEEN :date1 AND :date2')
            ->setParameter('date1', $date1)
            ->setParameter('date2', $date2)
            ->orderBy('m.date_heure', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllOpponents(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.equipe_adverse')
            ->distinct()
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Matches[] Returns an array of Matches objects
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

//    public function findOneBySomeField($value): ?Matches
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
