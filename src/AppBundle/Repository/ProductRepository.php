<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository {

    public function getAllOrderByDateQuery($orderBy = 'DESC') {
        $qb = $this->createQueryBuilder('p')
                ->select('p');
        
        if(strtoupper(trim($orderBy)) == 'DESC'){
            $qb->orderBy('p.createDate', 'DESC');
        } else{
            $qb->orderBy('p.createDate', 'ASC');
        }
        
        return $qb;
    }

}
