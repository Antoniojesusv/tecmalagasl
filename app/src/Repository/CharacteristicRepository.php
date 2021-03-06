<?php

namespace App\Repository;

use App\Entity\Characteristic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Characteristic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characteristic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characteristic[]    findAll()
 * @method Characteristic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacteristicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characteristic::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('characteristic');
    }

    public function findOneById($id)
    {
        return $this->find($id);
    }

    public function save($entity)
    {
        $em = $this->entityManager;
        $em->persist($entity);
        $em->flush();
    }

    public function update(): void
    {
        $this->entityManager->flush();
    }

    public function remove($entity)
    {
        $em = $this->entityManager;
        $em->remove($entity);
        $em->flush();
    }

    // /**
    //  * @return Characteristic[] Returns an array of Characteristic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characteristic
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
