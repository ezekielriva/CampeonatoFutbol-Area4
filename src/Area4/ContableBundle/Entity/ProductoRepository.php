<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductoRepository extends EntityRepository
{
    /**
     *
     * @param string $texto
     * @param integer $max
     * @return Producto
     */
    public function buscarlos($texto, $max){
        return $this->createQueryBuilder('p')
                ->where('p.nombre like \'%'.$texto.'%\'')
                ->setMaxResults($max)
                ->getQuery()
                ->getResult()
                ;
    }

    /**
     * Muestra los productos vigentes
     *
     * @return Productos
     * @author Ezekiel
     **/
    public function buscarVigentes($fecha)
    {
        $fechaWQuote = '\''.$fecha.'\'';
        $query = $this->createQueryBuilder('p')
                        ->join('p.especificaciondeProducto','ep')
                        ->where('ep.fecha_vigencia_inicio <= '.$fechaWQuote)
                        ->andWhere('ep.fecha_vigencia_finalizacion >= '.$fechaWQuote);
        return $query->getQuery()->getResult();
    }
}