<?php

namespace App\Repository;

use App\Entity\Price;
use App\Entity\Product;
use App\Entity\Region;
use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    /**
     * @return Price[]
     */
    public function getPrice(Region $region, Product $product)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from($this->getClassName(), 't')
            ->where('t.region = :region')
            ->andWhere('t.product = :product')
            ->setParameter('region', $region)
            ->setParameter('product', $product)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
