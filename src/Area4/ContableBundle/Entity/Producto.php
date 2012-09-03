<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\ContableBundle\Entity\Producto
 *
 * @ORM\Table(name="contable_Producto")
 * @ORM\Entity(repositoryClass="Area4\ContableBundle\Entity\ProductoRepository")
 */
class Producto
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
     * @var string $codigo 
     * @ORM\Column(name="codigo", type="string")
     */
    private $codigo;

    /**
     * @var float $precio
     *
     * @ORM\Column(name="precio", type="float")
     */
    private $precio;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="EspecificaciondeProducto", inversedBy="producto")
     * @ORM\JoinColumn(name="EspProd_id", referencedColumnName="id")
     *
     * @var Especificacion de Producto
     **/
    private $especificaciondeProducto;
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
     * Set precio
     *
     * @param float $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     *
     * @param integer $cant
     * @return double 
     */
    public function precioXCant($cant){
        return $this->precio * $cant;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set especificaciondeProducto
     *
     * @param Area4\ContableBundle\Entity\EspecificaciondeProducto $especificaciondeProducto
     */
    public function setEspecificaciondeProducto(\Area4\ContableBundle\Entity\EspecificaciondeProducto $especificaciondeProducto)
    {
        $this->especificaciondeProducto = $especificaciondeProducto;
    }

    /**
     * Get especificaciondeProducto 
     *
     * @return Area4\ContableBundle\Entity\EspecificaciondeProducto 
     */
    public function getEspecificaciondeProducto()
    {
        return $this->especificaciondeProducto;
    }

    /**
     * __toString
     *
     * @return string
     * @author ezekiel
     **/
    public function __toString()
    {
        return (string) $this->especificaciondeProducto->getNombre();
    }

    /**
     * get Nombre
     *
     * @return string
     * @author ezekiel
     **/
    public function getNombre()
    {
        return (string) $this->especificaciondeProducto->__toString();
    }
}