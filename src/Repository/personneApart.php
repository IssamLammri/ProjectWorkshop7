<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class personneApart extends EntityRepository{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    public function findpersonneByAppart(int $idappart){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT * FROM person_appart p ')
            ->getResult();
    }
}