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

    public function __construct()
    {
        $this->equipo = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}