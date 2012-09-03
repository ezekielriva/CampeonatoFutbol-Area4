<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Area4\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Area4\CampeonatoBundle\Entity\Jugador;

class DefaultController extends Controller {

	public function indexAction() {
		return $this->render('Area4UsuarioBundle:Default:index.html.twig');
	}

	/**
	 * Muestra la pantalla de un usuario
	 * @param integer $id id del usuario 
	 */
	public function verAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		
		$entity = $em->getRepository('Area4UsuarioBundle:Usuario')->find($id);

//		if (!$entity) {
//			throw $this->createNotFoundException('Unable to find Usuario entity.');
//		}

		return $this->render('Area4UsuarioBundle:Default:ver.html.twig',
						array(
				'usuario' => $entity,
		));
	}

	/**
	 * Lista para autocompletado de usuarios
	 *
	 * @return array : js
	 * @author ezekiel
	 **/
	public function indexAutoCompleteAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$entities = $em->getRepository('Area4UsuarioBundle:Usuario')->findAll();

		$script = 'usuarios = [';

		foreach ($entities as $entity) {
			$script = $script.'\''.$entity->getUsername().'\',';
		}

		$script = trim($script, ',');
		$script = $script.']';
		echo $script;

		return new Response();
	}

	/**
	 * Lista para autocompletado de usuarios sin equipos
	 *
	 * @return array : js
	 * @author ezekiel
	 **/
	public function indexAutoCompleteNoEquipoAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$usuarios = $em->getRepository('Area4UsuarioBundle:Usuario')->findAll();

		$script = '[';

		foreach ($usuarios as $usuario) {
			$jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($usuario->getId());
			if ($jugador) {
				if (!$jugador->getEquipo()) {
					$script = $script.'\''.$usuario->getUsername().'\',';
				}
			}
		}

		$script = trim($script, ',');
		$script = $script.']';

		if ($script === '[]' ){
			throw $this->createNotFoundException('No hay jugadores sin equipos.');
		}

		echo $script;

		return new Response();
	}

	/**
	 * Lista para autocompletado de todos los usuarios
	 *
	 * @return array : js
	 * @author ezekiel
	 **/
	public function indexAutoCompleteAllAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$usuarios = $em->getRepository('Area4UsuarioBundle:Usuario')->findAll();

		$script = '[';

		foreach ($usuarios as $usuario) {
			$script = $script.'\''.$usuario->getUsername().'\',';
		}

		$script = trim($script, ',');
		$script = $script.']';

		if ($script === '[]' ){
			throw $this->createNotFoundException('No hay jugadores.');
		}

		echo $script;

		return new Response();
	}
}
