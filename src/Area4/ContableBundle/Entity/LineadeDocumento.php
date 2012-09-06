<?php
namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="Area4\ContableBundle\Repository\LineadeDocumentoRepository")
* @ORM\Table(name="contable_LineadeDocumento")
*/
class LineadeDocumento
{
	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Documento")
	 * @ORM\JoinColumn(name="Documento_id", referencedColumnName="id")
	 * @var documento
	 */
	private $documento;

	/**
	 * @ORM\ManyToOne(targetEntity="Producto")
	 * @ORM:JoinColumn(name="Producto_id", referencedColumnName="id")
	 */
	private $producto;

	/**
	 * @var float $cantidad
	 *
	 * @ORM\Column(name="cantidad", type="float")
	 */
	private $cantidad;
	
	/**
	 * @var float $precio_t
	 *
	 * @ORM\Column(name="precio_t", type="float")
	 */
	private $precio_t;
	/**
	 * @var datetime $created_at
	 *
	 * @ORM\Column(name="created_at", type="datetime")
	 */
	private $created_at;

	/**
	 * @var datetime $updated_at
	 *
	 * @ORM\Column(name="updated_at", type="datetime")
	 */
	private $updated_at;


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
     * Set cantidad
     *
     * @param float $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Get cantidad
     *
     * @return float 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set precio_t
     *
     * @param float $precioT
     */
    public function setPrecioT($precioT)
    {
        $this->precio_t = $precioT;
    }

    /**
     * Get precio_t
     *
     * @return float 
     */
    public function getPrecioT()
    {
        return $this->precio_t;
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
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set documento
     *
     * @param Area4\ContableBundle\Entity\Documento $documento
     */
    public function setDocumento(\Area4\ContableBundle\Entity\Documento $documento)
    {
        $this->documento = $documento;
    }

    /**
     * Get documento
     *
     * @return Area4\ContableBundle\Entity\Documento 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set producto
     *
     * @param Area4\ContableBundle\Entity\Producto $producto
     */
    public function setProducto(\Area4\ContableBundle\Entity\Producto $producto)
    {
        $this->precio_t = $producto->getPrecio() * $this->cantidad;
        $this->producto = $producto;
    }

    /**
     * Get producto
     *
     * @return Area4\ContableBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Constructor
     *
     * @author ezekiel
     **/
    public function __construct()
    {
        $this->cantidad = 1;
        $this->created_at = new \DateTime('now');
        $this->updated_at = new \DateTime('now');
    }
}