<?php

namespace Area4\UsuarioBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UsuarioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsuarioRepository extends EntityRepository
{
	
	static private $Nivel= array(
		'ROLE_ADM' => 'ADMINSTADOR',
 		'ROLE_ORG' => 'ORGANIZADOR',
 		'ROLE_CAP' => 'CAPITAN DE EQUIPO',
 		'ROLE_JUG' => 'JUGADOR',
	);

	static private $levelInvitaciones = array(
		'ROLE_CAP' => 'CAPITAN DE EQUIPO',
 		'ROLE_JUG' => 'JUGADOR',
		);
	static private $levelInvitacionesCapitan = array(
 		'ROLE_JUG' => 'JUGADOR',
		);

	/**
	 * Devuleve los diferentes niviels
	 * @return array Niveles de usuaios
	 */
	static public function getAllLevels() {
		return  self::$Nivel;
	}
	
	
}