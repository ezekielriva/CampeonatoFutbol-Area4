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
        return $this->render('Area4StaticBundle:StaticBackend:menuAdmin.html.twig');
    }
}