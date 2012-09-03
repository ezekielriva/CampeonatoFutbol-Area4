<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\ContableBundle\Entity\EspecificaciondeProducto
 *
 * @ORM\Table(name="contable_EspecificaciondeProducto")
 * @ORM\Entity
 */
class EspecificaciondeProducto
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
     * Nombre de la especificación del producto
     * @ORM\Column(name="nombre", type="string", length="60")
     * @var string
     **/
    private $nombre;
    /**
     *
     * @var Producto
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="Producto")
     **/
    private $producto;

    /**
     * fecha de vigencia de inicio
     * @ORM\Column(name="fecha_vigencia_inicio", type="date")
     * @var \DateTime
     **/
    private $fecha_vigencia_inicio; 
    /**
     * fecha de vigencia de finalizacion
     * @ORM\Column(name="fecha_vigencia_finalizacion", type="date")
     * @var \DateTime
     **/
    private $fecha_vigencia_finalizacion; 
    /**
     * fecha de vencimiento del producto
     * @ORM\Column(name="fecha_vencimiento", type="date")
     * @var \DateTime
     **/
    private $fecha_vencimiento;

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
     * Set fecha_vigencia_inicio
     *
     * @param date $fechaVigenciaInicio
     */
    public function setFechaVigenciaInicio($fechaVigenciaInicio)
    {
        $this->fecha_vigencia_inicio = $fechaVigenciaInicio;
    }

    /**
     * Get fecha_vigencia_inicio
     *
     * @return date 
     */
    public function getFechaVigenciaInicio()
    {
        return $this->fecha_vigencia_inicio;
    }

    /**
     * Set fecha_vigencia_finalizacion
     *
     * @param date $fechaVigenciaFinalizacion
     */
    public function setFechaVigenciaFinalizacion($fechaVigenciaFinalizacion)
    {
        $this->fecha_vigencia_finalizacion = $fechaVigenciaFinalizacion;
    }

    /**
     * Get fecha_vigencia_finalizacion
     *
     * @return date 
     */
    public function getFechaVigenciaFinalizacion()
    {
        return $this->fecha_vigencia_finalizacion;
    }

    /**
     * Set fecha_vencimiento
     *
     * @param date $fechaVencimiento
     */
    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fecha_vencimiento = $fechaVencimiento;
    }

    /**
     * Get fecha_vencimiento
     *
     * @return date 
     */
    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    /**
     * Determina si el Producto se encuentra en Vigencia
     *
     * @return true : si se encuentra vigente
     * @return false : si no se encuentra vigente
     * @author ezekiel
     **/
    public function isVigente()
    {
        $date = new \DateTime('now');
        if ($date > $this->fecha_vigencia_inicio && $date < $this->fecha_vigencia_finalizacion){
            return true;
        }
        return false;
    }

    /**
     * Constructor
     *
     * @author ezekiel
     **/
    public function __construct()
    {
        $fecha_vigencia_inicio = new \DateTime('now');
        $fecha_vigencia_finalizacion = new \DateTime('now');
        $fecha_vencimiento = new \DateTime('now');
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add producto
     *
     * @param Area4\ContableBundle\Entity\Producto $producto
     */
    public function addProducto(\Area4\ContableBundle\Entity\Producto $producto)
    {
        $this->producto[] = $producto;
    }

    /**
     * Get producto
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * __toString
     *
     * @return string
     * @author ezekiel
     **/
    public function __toString()
    {
        return (string) sprintf("%s - Periodo[%s-%s]",
            $this->nombre,
            date_format($this->fecha_vigencia_inicio,'m/Y'),
            date_format($this->fecha_vigencia_finalizacion,'m/Y')
            );
    }
}