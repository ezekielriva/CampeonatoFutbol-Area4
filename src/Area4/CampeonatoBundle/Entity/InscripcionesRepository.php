<?php
namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class InscripcionesRepository extends EntityRepository
{
	static private $tiposInscripciones = array(
		'ROLE_CAP' => 'INSCRIPCIONES A EQUIPOS',
		'ROLE_JUG' => 'INSCRIPCIONES A JUGADORES',
		);

	static public function getTipoInscripciones() 
	{
		return self::$tiposInscripciones;
	}

	/**
	 * Busca si hay alguna inscripción abierta
	 * 
	 * @param $fecha : fecha en la cual se busca si existe una inscripcion abierta
	 * @param $tipo : si hay una inscripcion abierta de ese tipo
	 * @param $campeonato : campeonato al cual se busca las inscripciones
	 * @return array
	 * @author EzekielRiva
	 **/
	public function hayInscripcionesAbiertas($fecha, $tipo, $campeonato)
	{
		$query = $this->createQueryBuilder('i')
					->where('i.fecha_inicio <= '."'".$fecha."'")
					->andWhere('i.fecha_finalizacion >= '."'".$fecha."'")
					->andWhere('i.tipo = '."'".$tipo."'")
					->andWhere('i.Campeonato = '."'".$campeonato."'")
					->setMaxResults('1')
	                ->getQuery();
		return $query->getResult();
	}
}