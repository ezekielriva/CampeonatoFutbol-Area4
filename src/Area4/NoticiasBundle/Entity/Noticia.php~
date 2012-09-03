<?php

namespace Area4\NoticiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\DataCollector\DoctrineDataCollector;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Area4\NoticiasBundle\Entity\Noticia
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\NoticiasBundle\Entity\NoticiaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Noticia {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $titulo
	 *
	 * @ORM\Column(name="titulo", type="string", length=120)
	 */
	private $titulo;

	/**
	 * @var string $texto
	 *
	 * @ORM\Column(name="texto", type="string", length=10000)
	 */
	private $texto;

	/**
	 * @var datetime $created_at
	 *
	 * @ORM\Column(name="created_at", type="datetime",  nullable=true)
	 */
	private $created_at;

	/**
	 * @var datetime $updated_at
	 * 
	 * @ORM\Column(name="updated_at", type="datetime",  nullable=true)
	 */
	private $updated_at;

	/**
	 * @var string $foto
	 *
	 * @ORM\Column(name="foto", type="string", length=255,  nullable=true)
	 * @Assert\File(maxSize="2000000")
	 */
	private $foto;

	/**
	 * @var integer $activa
	 *
	 * @ORM\Column(name="activa", type="integer")
	 */
	private $activa;

	/**
	 * @orm\ManyToOne(targetEntity="Categoria", inversedBy="noticias")
	 * @orm\JoinColumn(name="categoria_id", referencedColumnName="id")
	 */
	private $categoria;

	/**
	 * @orm\ManyToOne(targetEntity="Area4\UsuarioBundle\Entity\Usuario", inversedBy="noticias")
	 * @orm\JoinColumn(name="usuario_id", referencedColumnName="id")
	 */
	private $usuario;

	public function __construct() {
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set titulo
	 *
	 * @param string $titulo
	 */
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

	/**
	 * Get titulo
	 *
	 * @return string 
	 */
	public function getTitulo() {
		return \str_replace("\\", "",$this->titulo);
	}

	/**
	 * Set texto
	 *
	 * @param string $texto
	 */
	public function setTexto($texto) {
		$this->texto = $texto;
	}

	/**
	 * Get texto
	 *
	 * @return string 
	 */
	public function getTexto() {
		return  \str_replace("\\", "",$this->texto);
	}

	/**
	 * Set created_at
	 *
	 * @param datetime $createdAt
	 */
	public function setCreatedAt($createdAt) {
		$this->created_at = $createdAt;
	}

	/**
	 * Get created_at
	 *
	 * @return datetime 
	 */
	public function getCreatedAt() {
		return $this->created_at;
	}

	/**
	 * Set updated_at
	 *
	 * @param datetime $updatedAt
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updated_at = $updatedAt;
	}

	/**
	 * Get updated_at
	 *
	 * @return datetime 
	 */
	public function getUpdatedAt() {
		return $this->updated_at;
	}

	/**
	 * Set foto
	 *
	 * @param string $foto
	 */
	public function setFoto($foto) {
		$this->foto = $foto;
	}

	/**
	 * Get foto
	 *
	 * @return string 
	 */
	public function getFoto() {
		if ($this->foto > "") {
			$f = $this->foto;
		} else {
			$f = "images/nofoto.jpg";
		}
		return $f;
	}

	/**
	 * Set activa
	 *
	 * @param integer $activa
	 */
	public function setActiva($activa) {
		$this->activa = $activa;
	}

	/**
	 * Get activa
	 *
	 * @return integer 
	 */
	public function getActiva() {
		return $this->activa;
	}

	/**
	 * Set categoria
	 *
	 * @param Area4\NoticiasBundle\Entity\Categoria $categoria
	 */
	public function setCategoria(\Area4\NoticiasBundle\Entity\Categoria $categoria) {
		$this->categoria = $categoria;
	}

	/**
	 * Get categoria
	 *
	 * @return Area4\NoticiasBundle\Entity\Categoria 
	 */
	public function getCategoria() {
		return $this->categoria;
	}

	/**
	 * Set usuario
	 *
	 * @param Area4\UsuarioBundle\Entity\Usuario $usuario
	 */
	public function setUsuario(\Area4\UsuarioBundle\Entity\Usuario $usuario) {
		$this->usuario = $usuario;
	}

	/**
	 * Get usuario
	 *
	 * @return Area4\UsuarioBundle\Entity\Usuario 
	 */
	public function getUsuario() {
		return $this->usuario;
	}

	/**
	 * Genera una reseña de la noticia
	 * @return String
	 */
	public function breve() {
		$string =  \str_replace("\\", "",$this->texto);
		$charlimit = 330;
		if (substr($string, $charlimit - 1, 1) != ' ') {
			$string = substr($string, '0', $charlimit);
			$array = explode(' ', $string);
			array_pop($array);
			$new_string = implode(' ', $array);

			return $new_string . ' ...';
		} else {
			return substr($string, '0', $charlimit - 1) . ' ...';
		}
	}

	/**
	 * Muesta lafecha de creacion de la nota
	 * @return DateTime
	 */
	public function getFecha() {
		return $this->getCreatedAt();
	}

	public function upload() {
		// la propiedad 'file' puede estar vacía si el campo no es obligatorio
		if (null === $this->foto) {
			return;
		}

		// aquí utilizamos el nombre de archivo original pero lo deberías
		// desinfectar por lo menos para evitar cualquier problema de seguridad
		// 'move' toma el directorio y nombre de archivo destino al cual trasladarlo
		$this->foto->move($this->getUploadRootDir(),
						$this->foto->getClientOriginalName());

		// fija la propiedad 'path' al nombre de archivo donde se guardó el archivo
		$this->setFoto($this->foto->getClientOriginalName());

		// limpia la propiedad 'file' puesto que ya no la vas a necesitar
		//	unset($this->foto);
	}

	protected $path = "";

	public function setPath($param) {
		$this->path = $param;
	}

	protected function getUploadRootDir() {
		return $this->path;
	}

	public function convertir() {
		$imagine = $this->getImagine();

		$dir = $this->getUploadRootDir() . "/" . $this->getFoto();
		$dirS = $dir . "_s";
		$image = $imagine->open($dir);
		$size = $image->getSize();
		$image
						->resize(new \Imagine\Image\Box(600, 300))
						->save($dir);
		$image
						->resize(new \Imagine\Image\Box(340, 170))
						->save($dirS);
		unlink($dir);
		unlink($dirS);
	}

	/*
	 * Guarada la fecha de creacion 
	 * @ORM\prePersist
	 */

	public function prePersist() {
		$this->setCreatedAt(new \DateTime());
		$this->setUpdatedAt(new \DateTime());
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}

	/**
	 * @ORM\preUpdate
	 */
	public function preUpdate() {
		$this->setUpdatedAt(new \DateTime());
		$this->setCreatedAt(new \DateTime());
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}


	/**
	 * Get texto en HTML remplazando nl por br
	 *
	 * @return string 
	 */
	public function getTextoHTML() {
		return \str_replace("\\", "", \nl2br($this->texto));
	}

}