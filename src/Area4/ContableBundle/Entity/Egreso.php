<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\ContableBundle\Entity\Egreso
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\ContableBundle\Entity\EgresoRepository")
 */
class Egreso
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
     * @var date $fecha
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string $numero_comprobante
     *
     * @ORM\Column(name="numero_comprobante", type="string", length=255)
     */
    private $numero_comprobante;

    /**
     * @var float $importe
     *
     * @ORM\Column(name="importe", type="float")
     */
    private $importe;

    /**
     * @var string $Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Area4\UsuarioBundle\Entity\Usuario")
     *
     */
    private $Usuario;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $update_at
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $update_at;

    /**
     * @var string $observaciones
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

    /**
     * Constructor
     *
     * @author ezekiel
     **/
    public function __construct()
    {
        $this->created_at = new \DateTime('now');
        $this->update_at = new \DateTime('now');
    }
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
     * Set fecha
     *
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return date 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set numero_comprobante
     *
     * @param string $numeroComprobante
     */
    public function setNumeroComprobante($numeroComprobante)
    {
        $this->numero_comprobante = $numeroComprobante;
    }

    /**
     * Get numero_comprobante
     *
     * @return string 
     */
    public function getNumeroComprobante()
    {
        return $this->numero_comprobante;
    }

    /**
     * Set importe
     *
     * @param float $importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    /**
     * Get importe
     *
     * @return float 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set Usuario
     *
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->Usuario = $usuario;
    }

    /**
     * Get Usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set update_at
     *
     * @param datetime $updateAt
     */
    public function setUpdateAt($updateAt)
    {
        $this->update_at = $updateAt;
    }

    /**
     * Get update_at
     *
     * @return datetime 
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Realiza antes de Actualizar
     * @ORM\preUpdate
     */
    public function preUpdate() {
        $this->update_at = new \DateTime('now');
    }
}