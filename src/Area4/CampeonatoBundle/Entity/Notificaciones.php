<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Notificaciones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Notificaciones
{
    static public $READ = 1;
    static public $UNREAD = 0;

    static public $ENABLED = 1;
    static public $NOENABLED = 0;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable="true")
     */
    private $url;

    /**
     * @var integer $wasRead
     *
     * @ORM\Column(name="wasRead", type="integer")
     */
    private $wasRead;
    /**
     * Guarda si la notificación esta habilitada
     *
     * @var boolean
     * @ORM\Column(name="enabled", type="integer")
     **/
    private $enabled;  
    /**
     * @ORM\ManyToOne(targetEntity="TipoNotificacion")
     * @ORM\JoinColumn(name="tipo", referencedColumnName="id")
     */
    private $tipo;
    /**
     * Usuario al cual se notifica
     *
     * @var Usuario
     * @ORM\ManyToOne(targetEntity="Area4\UsuarioBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="Usuario_id", referencedColumnName="id")
     **/
    private $Usuario;

    /**
     * Campeonato de la notificación : Utilizado para crear o invitar Equipos.
     * @ORM\ManyToOne(targetEntity="Campeonato")
     * @ORM\JoinColumn(name="Campeonato_id", referencedColumnName="id")
     * @var Campeonato
     **/
    private $Campeonato;
    /**
     * Equipo de la notificacion : Utilizado para agregar jugadores a Equipos.
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     * @var string
     **/
    private $Equipo;
    /**
     * Constructor
     *
     **/
    public function __construct()
    {
        $this->wasRead = Notificaciones::$UNREAD;
        $this->enabled = Notificaciones::$ENABLED;
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set wasRead
     *
     * @param integer $wasRead
     */
    public function setWasRead($wasRead)
    {
        $this->wasRead = $wasRead;
    }

    /**
     * Get wasRead
     *
     * @return integer 
     */
    public function getWasRead()
    {
        return $this->wasRead;
    }

    /**
     * Set Usuario
     *
     * @param Area4\UsuarioBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Area4\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->Usuario = $usuario;
    }

    /**
     * Get Usuario
     *
     * @return Area4\UsuarioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set Campeonato
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonato
     */
    public function setCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonato)
    {
        $this->Campeonato = $campeonato;
    }

    /**
     * Get Campeonato
     *
     * @return Area4\CampeonatoBundle\Entity\Campeonato 
     */
    public function getCampeonato()
    {
        return $this->Campeonato;
    }

    /**
     * Set Equipo
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipo
     */
    public function setEquipo(\Area4\CampeonatoBundle\Entity\Equipo $equipo)
    {
        $this->Equipo = $equipo;
    }

    /**
     * Get Equipo
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getEquipo()
    {
        return $this->Equipo;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     */
    public function setEnabled($enabled)
    {
        if (true === $enabled){
            $this->enabled = Notificaciones::$ENABLED;
        } else if (false === $enabled)
            $this->enabled = Notificaciones::$NOENABLED;
    }

    /**
     * Get enabled
     *
     * @return integer 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * estaHabilitada
     *
     * @return true : si esta habilitada
     * @return false : si no esta habilitada
     * @author ezekiel
     **/
    public function isEnabled()
    {
        if (Notificaciones::$ENABLED === $this->enabled)
            return true;
        else
            return false;
    }
}