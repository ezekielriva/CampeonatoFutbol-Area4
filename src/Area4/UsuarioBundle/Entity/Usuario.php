<?php
// src/Area4/UsuarioBundle/Entity/User.php

namespace Area4\UsuarioBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Usuario")
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_JUG');
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
     * Retorna el ROL como un string
     *
     * @return string
     * @author ezekiel
     **/
    public function getRoletoString()
    {
        if ($this->hasRole('ROLE_ORG')) {
            return "ORGANIZADOR";
        } else {
            if ($this->hasRole('ROLE_CAP'))
                return "CAPITAN";
            else
                return "JUGADOR";
        }
    }

    /**
     * Obtiene el rol de mayor jerarquia
     *
     * @return string
     * @author ezekiel
     **/
    public function getLastRole()
    {
        if ($this->hasRole('ROLE_ORG')) {
            return "ROLE_ORG";
        } else {
            if ($this->hasRole('ROLE_CAP'))
                return "ROLE_CAP";
            else
                return "ROLE_JUG";
        }
    }

    /**
     * Obtiene el role siguiente al que el tiene
     * Ejemplo: si es Organizador, devuelve Capitan
     *          si es Capitan, devuelve Jugador
     *
     * @return string
     * @author ezekiel
     **/
    public function getOneLessRole()
    {  
        if ($this->hasRole('ROLE_ORG')) {
            return "ROLE_CAP";
        } else {
            if ($this->hasRole('ROLE_CAP'))
                return "ROLE_JUG";
        }
    }
}