<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\ContableBundle\Entity\Cliente
 *
 * @ORM\Table(name="contable_Cliente")
 * @ORM\Entity(repositoryClass="Area4\ContableBundle\Entity\ClienteRepository")
 */
class Cliente
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Esta variable se utiliza de referencia para conectar el ContableBundle con otra Clase que se encuentra
     * dentro o fuera del ContableBundle;
     * @var $referencia
     * @ORM\OneToOne(targetEntity="Area4\CampeonatoBundle\Entity\Jugador")
     * @ORM\JoinColumn(name="Jugador_id", referencedColumnName="dni")
     */
    private $referencia;

    /**
     * @ORM\Column(name="domicilio", type="string", length="100")
     *
     */
    private $domicilio;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Obtiene el nombre de la Clase almacenada en referencia
     *
     * @return string
     * @author ezekiel
     **/
    public function getRazonSocial()
    {
        return (string) $this->referencia->getNombreCompleto();
    }
    /**
     * Obtener __toString de la clase de referencia
     *
     * @return string
     * @author ezekiel
     **/    
    public function __toString(){
        return $this->referencia->__toString();
    }

    /**
     * Set referencia
     *
     * @param Area4\CampeonatoBundle\Entity\Jugador $referencia
     */
    public function setReferencia(\Area4\CampeonatoBundle\Entity\Jugador $referencia)
    {
        $this->referencia = $referencia;
    }

    /**
     * Get referencia
     *
     * @return Area4\CampeonatoBundle\Entity\Jugador 
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * Get - domicilio
     *
     * @return string
     * @author ezekiel
     **/
    public function getDomicilio()
    {
        return (string) $this->domicilio;
    }
}