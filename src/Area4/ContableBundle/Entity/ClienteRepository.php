<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClienteRepository extends EntityRepository
{
    /**
     * @param String $txt
     * @param integer $max
     * @return Cliente 
     */
    public function findxTexto($txt,$max) {
        return $this->createQueryBuilder('c')
                ->where('c.nombre like \'%'.$txt.'%\'')
                ->orderBy('c.nombre', 'ASC')
                ->setMaxResults($max)
                ->getQuery()
                ->getResult();
    }

    /**
     * Busca al cliente con el siguiente username
     *
     * @return Cliente
     * @author ezekiel
     **/
    public function buscarPorUsername($username)
    {
        $query = $this->createQueryBuilder('c')
                ->join('c.referencia', 'r')
                ->join('r.Usuario', 'u')
                ->where('u.username like \'%'.$username.'%\'')
                ;
                
        return $query->getQuery()->getResult();
    }
}