<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TipoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TipoRepository extends EntityRepository {

	/**
	 * Genera la lista de tipos del menu
	 * @param type $param
	 */
	public function listaMenu() {
		return $this->findAll();
	}
	/**
	 *Busca todos los tios con exe nombre
	 * @param String $txt
	 * @return \Area4\ContableBundle\Entity\Tipo
	 */
	public function findByNombre($txt) {
	$tipo=	$this->createQueryBuilder('t')
					->where('t.nombre= :txt')
					->setParameter('txt', $txt)
					->getQuery()
					->execute();
	return $tipo;
	}

}