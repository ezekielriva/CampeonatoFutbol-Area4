<?php

namespace Area4\ContableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\ContableBundle\Entity\FPago
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\ContableBundle\Entity\FPagoRepository")
 */
class FPago {

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
	 * @ORM\Column (type="string", name="detalle", length=250)
	 * @var string $detalle
	 */
	private $detalle;

	/**
	 * @var float $interes
	 *
	 * @ORM\Column(name="interes", type="float")
	 */
	private $interes;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
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
	 * Set interes
	 *
	 * @param float $interes
	 */
	public function setInteres($interes) {
		$this->interes = $interes;
	}

	/**
	 * Get interes
	 *
	 * @return float
	 */
	public function getInteres() {
		return $this->interes;
	}


    /**
     * Set detalle
     *
     * @param string $detalle
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    /**
     * Get detalle
     *
     * @return string 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }
}