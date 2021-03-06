<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
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
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->getVisileQuery();

        if($search->getMaxPrice()){
            $query = $query->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if($search->getMinSurface()){
            $query = $query->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }

        if($search->getOptions()->count() > 0){
            $k = 0;
            foreach ($search->getOptions() as $option) {
                $k++;
                $query = $query->andWhere(":options$k MEMBER OF p.options")
                    ->setParameter("options$k", $option);
            }
}
        return $query->getQuery();
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
