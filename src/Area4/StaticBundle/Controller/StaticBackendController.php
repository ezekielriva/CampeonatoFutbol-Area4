<?php
namespace Area4\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaticBackendController extends Controller
{
	/**
	 * @Route("/admin",name="menu_admin")
	 * @Template()
	 **/
    public function menuAdminAction()
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	$em = $this->getDoctrine()->getEntityManager();
    	$jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        return $this->redirect($this->generateUrl('jugador_perfil',array(
        	'dni' => ($jugador) ? $jugador->getDni() : '0' ,
        	)));
    }
}