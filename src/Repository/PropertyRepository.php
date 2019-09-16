<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(): Query
    {
        return $this->getVisileQuery()
            ->getQuery();
    }

    /**
     * @return array Property[]
     */
    public function findLatest(): array
    {
        return $this->getVisileQuery()
            ->setMaxResults('4')
            ->getQuery()
            ->getResult()
        ;

    }

    /**
     * @return QueryBuilder
     */
    private function getVisileQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where("p.sold = false");
    }
}
