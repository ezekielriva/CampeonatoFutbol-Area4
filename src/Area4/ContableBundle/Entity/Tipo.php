<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * es el tipo de documento que se genera
 *
 *
 *
 * Area4\ContableBundle\Entity\Tipo
 *
 * @ORM\Table(name="contable_TipoDocumento", uniqueConstraints={@ORM\UniqueConstraint(name="nombre_u", columns={"nombre"})})
 * @ORM\Entity(repositoryClass="Area4\ContableBundle\Entity\TipoRepository")
 */
class Tipo {

    public static $SIN_MOVIMIENTO_DINERO = 0;
    public static $SIN_MOVIMIENTO_STOCK = 0;
    public static $CON_MOVIMIENTO_DINERO_POSITIVO = 1;
    public static $CON_MOVIMIENTO_DINERO_NEGATIVO = -1;
    public static $CON_MOVIMIENTO_STOCK = 1;


    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;
    /**
     * @var integer $ultimo;
     *
     * @ORM\Column(name="ultimo", type="integer")
     */
    private $ultimo;
    /**
     * @var string $letra
     *
     * @ORM\Column(name="letra", type="string", length=1)
     */
    private $letra;
    /**
     * @var float $plata
     *
     * @ORM\Column(name="plata", type="float")
     */
    private $plata;
    /**
     * @var integer $stock
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;
    /**
     * define los roles que permiten ver este tipo de documento
     * @ORM\Column (type="string", name="roles",  length=50)
     * @var string $roles
     */
    private $roles;

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set letra
     *
     * @param string $letra
     */
    public function setLetra($letra) {
        $this->letra = $letra;
    }

    /**
     * Get letra
     *
     * @return string
     */
    public function getLetra() {
        return $this->letra;
    }

    /**
     * Set ultimo
     *
     * @param integer $ultimo
     */
    public function setUltimo($ultimo) {
        $this->ultimo = $ultimo;
    }

    /**
     * Get ultimo
     *
     * @return integer
     */
    public function getUltimo() {
        return $this->ultimo;
    }

    /**
     * Set plata
     *
     * @param float $plata
     */
    public function setPlata($plata) {
        $this->plata = $plata;
    }

    /**
     * Get plata
     *
     * @return float
     */
    public function getPlata() {
        return $this->plata;
    }

    /**
     * Devuelve el ultimo numero y suma uno al ultimo
     *
     * @return integer
     */
    public function siguiente() {
        $ult = $this->ultimo;
        $this->ultimo += $this->ultimo;
        return $ult;
    }

    public function __toString() {
        return $this->nombre.' '.$this->letra;
    }

    /**
     * Set roles
     *
     * @param string $roles
     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }

    /**
     * Get roles
     *
     * @return string
     */
    public function getRoles() {
        return $this->roles;
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
     * Set stock
     *
     * @param integer $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Constructor
     *
     * @author ezekiel
     **/
    public function __construct()
    {
        $this->ultimo = 0;
        $this->stock = Tipo::$SIN_MOVIMIENTO_STOCK;
        $this->roles = 'ROLE_ADMIN';
    }

    /**
     * Utilizado para TipoType
     *
     * @return void
     * @author 
     **/
    static public function getPlataChoices()
    {
        return array(
            Tipo::$SIN_MOVIMIENTO_DINERO => 'No mueve',
            Tipo::$CON_MOVIMIENTO_DINERO_POSITIVO => 'Ingresa',
            Tipo::$CON_MOVIMIENTO_DINERO_NEGATIVO => 'Egresa'
            );
    }
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    static public function getStockChoices()
    {
        return array(
            Tipo::$SIN_MOVIMIENTO_STOCK => 'No mueve',
            Tipo::$CON_MOVIMIENTO_STOCK => 'Si mueve',
            );
    }

    /**
     * Plata to string
     *
     * @return string
     * @author ezekiel 
     **/
    public function getPlataToString()
    {
        $array = array(
            Tipo::$SIN_MOVIMIENTO_DINERO => 'No mueve',
            Tipo::$CON_MOVIMIENTO_DINERO_POSITIVO => 'Ingresa',
            Tipo::$CON_MOVIMIENTO_DINERO_NEGATIVO => 'Egresa'
            );
        return $array[$this->plata];
    }

    /**
     * Aumenta el ultimo en 1 unidad
     *
     * @return void
     * @author ezekiel
     **/
    public function plusOneToUltimo()
    {
        $this->ultimo = $this->ultimo + 1;
    }
}