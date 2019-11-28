<?php

namespace App\Repository;

use App\Entity\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Slider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slider::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('product');
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
}
