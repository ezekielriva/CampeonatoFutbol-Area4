<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Equipo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\EquipoRepository")
 */
class Equipo {

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
     * @var Campeonato[] $campeonatos;
     * @ORM\ManyToMany(targetEntity="Campeonato", mappedBy="Equipos")
     */
    protected $Campeonatos;
    /**
     * @orm:OneToMany(targetEntity="Partido", mappedBy="local")
     */
    /*
     * @var Partido[] $locales;
     */
    protected $locales;
    /**
     * @OneToMany(targetEntity="Partido", mappedBy="visitante")
     */
    /**
     * @var Partido[] $locales; 
     */
    protected $visitantes;
    /**
     * @var string $imagen
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;
    /**
     *  @ORM\ManyToMany(targetEntity="Jugador", mappedBy="Equipo")
     */
    private $Jugadores;

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
     * Set imagen
     *
     * @param string $imagen
     */
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen() {
        return $this->imagen;
    }

    public function __construct() {
        $this->campeonatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->locales = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visitantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Jugadores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add campeonatos
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonatos
     */
    public function addCampeonatos(\Area4\CampeonatoBundle\Entity\Campeonato $campeonatos) {
        $this->campeonatos[] = $campeonatos;
    }

    /**
     * Get campeonatos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCampeonatos() {
        return $this->campeonatos;
    }

    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Add campeonatos
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonatos
     */
    public function addCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonatos) {
        $this->campeonatos[] = $campeonatos;
    }

    /**
     * Add Jugadores
     *
     * @param Area4\CampeonatoBundle\Entity\Jugador $jugadores
     */
    public function addJugador(\Area4\CampeonatoBundle\Entity\Jugador $jugadores) {
        $this->Jugadores[] = $jugadores;
    }

    /**
     * Get Jugadores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJugadores() {
        return $this->Jugadores;
    }

    /* Manejo de Archivo */

    protected $path = "/atah/web/img/equipos/";

    public function setPath($param) {
        $this->path = $param;
    }

    protected function getUploadRootDir() {
        return $this->path;
    }

    public function upload() {
        // la propiedad 'file' puede estar vacía si el campo no es obligatorio
        if (null === $this->imagen) {
            return;
        }

        // aquí utilizamos el nombre de archivo original pero lo deberías
        // desinfectar por lo menos para evitar cualquier problema de seguridad
        // 'move' toma el directorio y nombre de archivo destino al cual trasladarlo
        $extension = $this->imagen->guessExtension();
        if (!$extension) {
            // no puede adivinar la extensión
            $extension = 'jpg';
        }
        $this->imagen->move($this->getUploadRootDir(),
                $this->imagen->getClientOriginalName());

        // fija la propiedad 'path' al nombre de archivo donde se guardó el archivo
        $this->setImagen($this->path . '/' . $this->imagen->getClientOriginalName());

        // limpia la propiedad 'file' puesto que ya no la vas a necesitar
        //	unset($this->foto);
    }

}