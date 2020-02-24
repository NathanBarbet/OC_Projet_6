<?php

namespace App\Repository;

use App\Entity\Tricks;
use App\Entity\Medias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query;

/**
 * @method Tricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tricks[]    findAll()
 * @method Tricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tricks::class);
    }

    public function findRecentTricks($page)
    {
      return $this->createQueryBuilder('t')
          ->orderBy('t.dateModify', 'DESC')
          ->setMaxResults(6)
          ->setFirstResult($page*6)
          ->getQuery()
          ->getResult();
    }

    public function findSingleTrick($id)
    {
      return $this->createQueryBuilder('t')
          ->where("t.id = $id")
          ->getQuery()
          ->getResult();
    }

    public function verifyName($id, $name)
    {
      return $this->createQueryBuilder('t')
          ->where("t.id != $id")
          ->andWhere("t.name = :name")
          ->setParameter('name', $name)
          ->getQuery()
          ->getResult();
    }



    // /**
    //  * @return Tricks[] Returns an array of Tricks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tricks
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
