<?php

namespace Area4\NoticiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\NoticiasBundle\Entity\Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\NoticiasBundle\Entity\CategoriaRepository")
 */
class Categoria
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
     * @ORM\Column(name="nombre", type="string", length=40)
     */
    private $nombre;

     /**
		  * @orm\OnetoMany(targetEntity="Noticia",mappedBy="categoria")
		  */
		
		 private $noticias;


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
    public function __construct()
    {
        $this->noticias = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add noticias
     *
     * @param Area4\NoticiasBundle\Entity\Noticia $noticias
     */
    public function addNoticias(\Area4\NoticiasBundle\Entity\Noticia $noticias)
    {
        $this->noticias[] = $noticias;
    }

    /**
     * Get noticias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNoticias()
    {
        return $this->noticias;
    }
		
		public function __toString() {
			return $this->getNombre();
		}

    /**
     * Add noticias
     *
     * @param Area4\NoticiasBundle\Entity\Noticia $noticias
     */
    public function addNoticia(\Area4\NoticiasBundle\Entity\Noticia $noticias)
    {
        $this->noticias[] = $noticias;
    }
}