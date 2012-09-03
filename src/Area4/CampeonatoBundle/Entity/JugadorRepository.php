<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * JugadorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JugadorRepository extends EntityRepository
{
    private static $sexos = array('M' => 'Masculino', 'F' => 'Femenino' );

    /**
     * Array con los sexos disponibles M, F
     * @return array c/ los sexos disponibles
     */
    public static function getSexos()
    {
        return self::$sexos;
    }

    /**
     * Lista los jugadores ordenados por carnet
     * @return Jugador[]
     */
    public function listadoCarnet(){
        return $this->createQueryBuilder('j')
                ->orderBy('j.carnet', 'ASC')
                ->getQuery()
                //->getSql()
                ->getResult();
    }


    /**
     * Filtro por Sexo, equipo y categoría.
     * @todo Refinar codigo
     * @param string $sexo
     * @param Equipo $equipo
     * @param Categoria $cat
     * @return Jugador[]
     */
    public function filtro($sexo=-1,$Equipo=null,$Categoria=null,$bloque=null,$color=null){
        $query = $this->createQueryBuilder('j');
        if ($sexo != -1)
            $query = $query->andWhere ('j.sexo = '.$sexo);
        if(!is_null($Equipo))
            $query->join('j.Equipo','e')->andWhere('e.id = '.$Equipo);
        if(!is_null($Categoria))
            $query->join('j.Categoria','c')->andWhere('c.id = '.$Categoria);
        if(!is_null($bloque))
            $query->andWhere('j.bloque = \''.$bloque.'\'');
        if (!is_null($color))
            $query->andWhere('j.color = \''.$color.'\'');
        $query->orderBy('j.apellido','ASC')->addOrderBy('j.carnet','ASC');
        //die($query);
        return $query->getQuery()->getResult();
    }

    /**
     * Busca los jugadores anotados en un Partido y son
     * de un equipo dado.
     */
    public function equipoPartido($Partido, $Equipo){
        $query = $this->createQueryBuilder('j')
                        ->join('j.Equipo','e')
                        ->join('j.Partido','p')
                        ->where('e.id = '.$Equipo)
                        ->andWhere('p.id ='.$Partido);
        return $query->getQuery()->getResult();
    }

    public function equipoPartidoCategoria($Equipo, $Partido, $Categoria){
        $query = $this->createQueryBuilder('j');
        if(!is_null($Equipo))
            $query->join('j.Equipo','e')->andWhere('e.id = '.$Equipo);
        if(!is_null($Partido))
            $query->join('j.Partido','p')->andWhere('p.id = '.$Partido);
        if(!is_null($Categoria))
            $query->andWhere('j.Categoria = '.$Categoria);
        $query->orderBy('j.apellido','ASC');
        return $query->getQuery()->getResult();
    }

    public function findByDni($dni){
        return $this->createQueryBuilder('j')
                        ->where('j.dni = '.$dni)
                        ->getQuery()
                        ->getResult();
    }

    public function findByGrupoFamiliar($id){
        return $this->createQueryBuilder('j')
                    ->where('j.GrupoFamiliar = '.$id)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Busca todos los jugadores inscriptos sin equipos
     *
     * @author ezekiel
     **/
    public function buscarSinEquipo()
    {
        return $this->createQueryBuilder('j')
                    ->where('j.Equipo = NULL ')
                    ->getQuery()
                    ->getResult();
    }
}
