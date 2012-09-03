<?php

namespace Area4\ContableBundle\Util;
/**
 * Clase utilizada para crear un formulario de egreso
 *
 * @author ezekielriva
 **/
class EgresoForm
{
	private $fecha_inicio;
	private $fecha_fin;

	/**
	 * Constructor
	 *
	 **/
	public function __construct($fecha_inicio, $fecha_fin)
	{
		$this->fecha_inicio = $fecha_inicio;
		$this->fecha_fin = $fecha_fin;
	}

	/**
	 * Get - fecha_inicio
	 *
	 * @return \DateTime
	 **/
	public function getFechaInicio()
	{
		return $this->fecha_inicio;
	}
	/**
	 * Get - fecha_fin
	 *
	 * @return \DateTime
	 **/
	public function getFechaFin()
	{
		return $this->fecha_fin;
	}

	/**
	 * Set - fecha_inicio
	 *
	 **/
	public function setFechaInicio($fecha_inicio)
	{
		$this->fecha_inicio = $fecha_inicio;
	}

	/**
	 * Set - fecha_inicio
	 *
	 **/
	public function setFechaFin($fecha_fin)
	{
		$this->fecha_fin = $fecha_fin;
	}
} // END public class EgresoForm
