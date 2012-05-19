<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Categoria
 *
 * @ORM\Table(name="Camp_Categoria")
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\CategoriaRepository")
 */
class Categoria {

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
	 * @ORM\Column(name="nombre", type="string", length=60)
	 */
	private $nombre;

	/**
	 * @ORM\Column (type="integer", name="edad_ini")
	 * @var integer $edadIni
	 */
	private $edadIni;

	/**
	 * @ORM\Column (type="integer", name="edad_fin")
	  @var integer $edadFin
	 */
	private $edadFin;

        /**
         * @ORM\Column (type="integer", name="anio_camp")
         * @var integer $anio_camp
         */
        private $anio_camp;

	/**
	 * @ORM\ManyToOne(targetEntity="Partido")
	 * @ORM\JoinColumn(name="Partido_id", referencedColumnName="id")
	 */
	private $partidos;

	/**
	 * @ORM\OneToMany(targetEntity="Campeonato", mappedBy="Categorias") 
	 */
	private $Campeonato;

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
	 * Contructor
	 */
	public function __construct() {
		$this->Campeonato = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Set edadIni
	 *
	 * @param integer $edad
	 */
	public function setEdadIni($edad) {
		$this->edadIni = $edad;
	}

	/**
	 * Get edadIni
	 *
	 * @return integer
	 */
	public function getEdadIni() {
		return $this->edadIni;
	}

	/**
	 * Set edadFin
	 *
	 * @param integer $edad
	 */
	public function setEdadFin($edad) {
		$this->edadFin = $edad;
	}

	/**
	 * Get edadFin
	 *
	 * @return integer
	 */
	public function getEdadFin() {
		return $this->edadFin;
	}

        /**
	 * Set anio_camp
	 *
	 * @param integer $anio
	 */
	public function setAnioCamp($anio) {
		$this->anio_camp = $anio;
	}

	/**
	 * Get anio_camp
	 *
	 * @return integer
	 */
	public function getAnioCamp() {
		return $this->anio_camp;
	}

	/**
	 * Set partidos
	 *
	 * @param Area4\CampeonatoBundle\Entity\Partido $partidos
	 */
	public function setPartidos(\Area4\CampeonatoBundle\Entity\Partido $partidos) {
		$this->partidos = $partidos;
	}

	/**
	 * Get partidos
	 *
	 * @return Area4\CampeonatoBundle\Entity\Partido 
	 */
	public function getPartidos() {
		return $this->partidos;
	}

	/**
	 * Add Campeonato
	 *
	 * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonato
	 */
	public function addCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonato) {
		$this->Campeonato[] = $campeonato;
	}

	/**
	 * Get Campeonato
	 *
	 * @return Doctrine\Common\Collections\Collection 
	 */
	public function getCampeonato() {
		return $this->Campeonato;
	}

	/**
	 * 
	 */
	public function __toString() {
		return $this->getNombre();
	}
}