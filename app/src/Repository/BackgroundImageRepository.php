<?php

namespace App\Repository;

use App\Entity\BackgroundImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BackgrounfImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackgrounfImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackgrounfImage[]    findAll()
 * @method BackgrounfImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackgroundImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackgroundImage::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function getAll()
    {
        return $this->findAll();
    }

    public function findOneById($id)
    {
        return $this->find($id);
    }

    public function update(): void
    {
        $this->entityManager->flush();
    }
}
