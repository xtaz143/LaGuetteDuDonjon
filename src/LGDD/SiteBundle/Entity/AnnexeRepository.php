<?php

namespace LGDD\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AnnexeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnexeRepository extends EntityRepository
{
	public function findAllWithout($id){
		$qb = $this->createQueryBuilder('a');

		if($id != 0){
		 $qb->where('a.id <> :id')
			->setParameter('id',$id);
		}

	  	return $qb->getQuery()
	              ->getResult();
	}
}
