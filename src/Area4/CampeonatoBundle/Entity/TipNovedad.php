<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\TipNovedad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\TipNovedadRepository")
 * @ORM\Entity
 */
class TipNovedad
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     */
    private $nombre;


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

    public function __toString(){
        return $this->nombre;
    }
}