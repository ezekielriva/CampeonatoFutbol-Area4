<?php

namespace Area4\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaticFrontendController extends Controller
{
    /**
     * @Route("/", name="home_frontend")
     * @Template()
     */
    public function homeAction()
    {
        return array();
    }
}
