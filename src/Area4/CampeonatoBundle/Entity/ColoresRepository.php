<?php
namespace Area4\CampeonatoBundleBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ColoresRepository extends EntityRepository
{

	public static function getColores()
	{
		return $this->createQueryBuilder('c')
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY)
            ;
    }
}	