<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Campeonato
 *
 * @ORM\Table(name="Campeonato")
 * @ORM\Entity
 */
class Campeonato
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string $provincia
     *
     * @ORM\Column(name="provincia", type="string", length=45, nullable=false)
     */
    private $provincia;

    /**
     * @var Equipo
     *
     * @ORM\ManyToMany(targetEntity="Equipo", inversedBy="campeonato")
     * @ORM\JoinTable(name="campeonato_has_equipo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Campeonato_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     *   }
     * )
     */
    private $equipo;

    /**
     * @ORM\Column(name="finalizo", type="integer", length=1, nullable=false)
     */
    private $finalizo;
    
    public function __construct()
    {
        $this->finalizo = 0;
        $this->provincia = 'TUCUMAN';
        $this->equipo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set provincia
     *
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = strtoupper($provincia);
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Add equipo
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipo
     */
    public function addEquipo(\Area4\CampeonatoBundle\Entity\Equipo $equipo)
    {
        $this->equipo[] = $equipo;
    }

    /**
     * Get equipo
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * Set finalizo
     *
     * @param int $finalizo
     */
    public function setFinalizo($finalizo)
    {
        $this->finalizo = $finalizo;
    }

    /**
     * Get finalizo
     *
     * @return boolean 
     */
    public function getFinalizo()
    {
        if ($this->finalizo === 0){
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * toString
     *
     **/
    public function __toString()
    {
        return $this->nombre;
    }
}