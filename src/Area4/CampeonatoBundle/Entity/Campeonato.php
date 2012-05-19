<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Area4\CampeonatoBundle\Entity\Campeonato
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\CampeonatoRepository")
 */
class Campeonato {

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
	 * @var string $deporte
	 *
	 * @ORM\Column(name="deporte", type="string", length=40)
	 */
	private $deporte;
	
	/**
	 * @var Equipo[] $equipos
	 * @ORM\ManyToMany(targetEntity="Equipo", inversedBy="Campeonatos")
     * @ORM\JoinTable(name="Campeonato_Equipo",
     *      joinColumns={@ORM\JoinColumn(name="campeonato_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="equipo_id", referencedColumnName="id")}
     *      )	
	 */
	private $Equipos;

	/**
	* @ORM\OneToMany(targetEntity="Categoria", mappedBy="Partido", cascade={"persist"})
	*
	*/
	private $Partido;

	/**
	 *  @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="Categoria_id", referencedColumnName="id")
	 */
	
	private $Categorias;
	
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
	 * Set deporte
	 *
	 * @param string $deporte
	 */
	public function setDeporte($deporte) {
		$this->deporte = $deporte;
	}

	/**
	 * Get deporte
	 *
	 * @return string 
	 */
	public function getDeporte() {
		return $this->deporte;
	}

	
	public function __construct() {
		$this->equipos = new \Doctrine\Common\Collections\ArrayCollection();
		$this->partidos = new \Doctrine\Common\Collections\ArrayCollection();
	}


    /**
     * Add equipos
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipos
     */
    public function addEquipos(\Area4\CampeonatoBundle\Entity\Equipo $equipos)
    {
        $this->equipos[] = $equipos;
    }

    /**
     * Get equipos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipos()
    {
        return $this->Equipos;
    }
	
    public function setEquipos(\Area4\CampeonatoBundle\Entity\Equipo $equipos){
        $this->equipos[] = $equipos;
    }
    
    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Add equipos
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipos
     */
    public function addEquipo(\Area4\CampeonatoBundle\Entity\Equipo $equipos)
    {
        $this->equipos[] = $equipos;
    }

    /**
     * Add Equipos
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $equipos
     */
    public function addCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $equipos)
    {
        $this->Equipos[] = $equipos;
    }

    /**
     * Set Categorias
     *
     * @param Area4\CampeonatoBundle\Entity\Categoria $categorias
     */
    public function setCategorias(\Area4\CampeonatoBundle\Entity\Categoria $categorias)
    {
        $this->Categorias = $categorias;
    }

    /**
     * Get Categorias
     *
     * @return Area4\CampeonatoBundle\Entity\Categoria 
     */
    public function getCategorias()
    {
        return $this->Categorias;
    }

    /**
     * Add Partido
     *
     * @param Area4\CampeonatoBundle\Entity\Categoria $partido
     */
    public function addCategoria(\Area4\CampeonatoBundle\Entity\Categoria $partido)
    {
        $this->Partido[] = $partido;
    }

    /**
     * Get Partido
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartido()
    {
        return $this->Partido;
    }
}