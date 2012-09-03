<?php

namespace Area4\Bundle\CampeonatoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TipoNotificacionRepository extends EntityRepository
{
	/**
	 * Busca por el nombre corto
	 *
	 * @return TipoNotificacion
	 * @author ezekiel
	 **/
	public function shortName($short)
	{
		$query = $this->createQueryBuilder('tn')
                ->where('tn.short_name = \''.$short.'\'')
                ->getQuery();
        return $query->getResult();
	}
}
