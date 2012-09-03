<?php

namespace Area4\CampeonatoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Colores
 *
 * @ORM\Table(name="Colores")
 * @ORM\Entity
 */
class Colores
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
     * @ORM\Column(name="nombre", type="string", length=15, nullable=false)
     */
    private $nombre;

    /**
     * @var Equipo
     *
     * @ORM\ManyToMany(targetEntity="Equipo", mappedBy="colores")
     */
    private $equipo;

    public function __construct()
    {
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

    public function __toString()
    {
        return $this->nombre;
    }
}