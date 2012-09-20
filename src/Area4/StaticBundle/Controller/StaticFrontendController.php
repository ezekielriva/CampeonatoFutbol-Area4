<?php

namespace Area4\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Campeonato;
use Area4\CampeonatoBundle\Entity\Partido;
use Area4\CampeonatoBundle\Entity\novedad;

class StaticFrontendController extends Controller
{
    /**
     * @Route("/", name="home_frontend")
     * @Template()
     */
    public function homeAction()
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
        return array('user'=>$user);
    }

    /**
     * Lista todos los campeonatos en el front
     *
     * @Route("/campeonatos/indice", name="index_campeonato_front")
     * @Template()
     * @return twig
     * @author ezekiel 
     **/
    public function indexCampeonatoFrontAction()
    {
        $request = $this->getRequest();
        $allCampeonatos = ($request->query->get('all') === "true") ? true : false ;

        $em = $this->getDoctrine()->getEntityManager();
        
    	if($allCampeonatos) {
			$campeonatos = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findAll();
    	} else {
    		$campeonatos = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findByFinalizo(Campeonato::$EN_JUEGO);
    	}
        return array(
        	'entities' => $campeonatos,
        	);
    }

    /**
     * Lista todos los partidos de un campeonato separados por fechas
     *
     * @Route("/campeonatos/partidos", name="index_partidos_front")
     * @Template()
     * @return twig
     * @author ezekiel
     **/
    public function partidosByCampeonatoFrontAction()
    {
    	$request = $this->getRequest();
    	$idCampeonato = $request->query->get('campeonato');
        $formato = $request->query->get('formato');

    	$em = $this->getDoctrine()->getEntityManager();

        $partidoRepository = $em->getRepository('Area4CampeonatoBundle:Partido');
    	switch ($formato) {
            case 'all':
                $partidos = $partidoRepository->findBy(array('campeonato'=>$idCampeonato),array('fecha'=>'ASC'));
                break;
            case 'JUG':
                $partidos = $partidoRepository->findBy(array('campeonato'=>$idCampeonato,'estado'=>Partido::$POR_JUGARSE),array('fecha'=>'ASC'));
                break;
            case 'FIN':
                $partidos = $partidoRepository->findBy(array('campeonato'=>$idCampeonato,'estado'=>Partido::$FINALIZADO),array('fecha'=>'ASC'));
                break;
            default:
                $partidos = $partidoRepository->findBy(array('campeonato'=>$idCampeonato),array('fecha'=>'ASC'));
                break;
        }

    	$fechas = array();
    	foreach ($partidos as $partido) {
    		$fechas[$partido->getFecha()][] = $partido;
    	}

    	return array(
    		'title' => 'Lista de partidos',
    		'fechas' => $fechas,
    		'categoria_class' => ($partidos) ? $partidos[0]->getCampeonato()->getCategoria() : "A" ,
    		);
    }

    /**
     * Muestra una mini planilla de partido en el front
     *
     * @Route("/campeonatos/partidos/planilla", name="planilla_partidos_front")
     * @Template()
     * @return twig
     * @author ezekiel
     **/
    public function planillaPartidoFrontAction()
    {
    	$request = $this->getRequest();
    	$idPartido = $request->query->get('id');
    	$em = $this->getDoctrine()->getEntityManager();
    	$partido = $em->getRepository('Area4CampeonatoBundle:Partido')->find($idPartido);

    	$novedades = $em->getRepository('Area4CampeonatoBundle:novedad')->findByPartido($idPartido);

    	$goles = array();
    	$amarillas = array();
    	$rojas = array();
    	foreach ($novedades as $novedad) {
    		if (novedad::$TipoNovedadArrayToString['Gol-Local'] == $novedad->getTipoNovedad()) {
    			$goles['Local'][] = $novedad;
    		}
    		if (novedad::$TipoNovedadArrayToString['Gol-Visitante'] == $novedad->getTipoNovedad()) {
    			$goles['Visitante'][] = $novedad;
    		}
    		if (novedad::$TipoNovedadArrayToString['Tarjeta Amarilla'] == $novedad->getTipoNovedad()){
    			$equipo = $novedad->getJugador()->getEquipo();
    			if ($equipo == $partido->getLocal())
    				$amarillas['Local'][] = $novedad;
    			else
    				$amarillas['Visitante'][] = $novedad;
    		}
    		if (novedad::$TipoNovedadArrayToString['Tarjeta Roja'] == $novedad->getTipoNovedad()) {
    			$equipo = $novedad->getJugador()->getEquipo();
    			if ($equipo == $partido->getLocal())
    				$rojas['Local'][] = $novedad;
    			else
    				$rojas['Visitante'][] = $novedad;
    		}
    	}

    	return array(
    		'partido'=> $partido, 
    		'novedades'=> $novedades,
    		'goles' => $goles,
    		'amarillas' => $amarillas,
    		'rojas' => $rojas,
    		);
    }

    /**
     * Muestra los proximos compromisos del equipo
     * @Route("/campeonatos/partidos/equipo", name="partidos_equipo_front")
     * @Template("Area4StaticBundle:StaticFrontend:partidosByCampeonatoFront.html.twig")
     * @return twig
     * @author ezekiel
     **/
    public function proximosEncuentrosAction()
    {
    	$request = $this->getRequest();
    	$idEquipo = $request->query->get('equipo');
    	$idCampeonato = $request->query->get('campeonato');

    	$em = $this->getDoctrine()->getEntityManager();
    	$partidos = $em->getRepository('Area4CampeonatoBundle:Partido')->proximosCompromisos($idEquipo, $idCampeonato);

    	$fechas = array();
    	foreach ($partidos as $partido) {
    		$fechas[$partido->getFecha()][] = $partido;
    	}

    	return array(
    		'title'=> 'Proximos encuentros', 
    		'fechas' => $fechas, 
    		'categoria_class' => 'A',
    		);
    }

    /**
     * Crea la tabla de posiciones del campeonato
     * @Route("/campeonatos/tabla", name="campeonato_tabla_posiciones")
     * @Template()
     * @return twig
     * @author ezekiel
     **/
    public function tablaPosicionesFrontAction()
    {
    	$request = $this->getRequest();
    	$idCampeonato = $request->query->get('campeonato');
		
		$em = $this->getDoctrine()->getEntityManager();

    	return array(
    		'tabla' => $em->getRepository('Area4CampeonatoBundle:Campeonato')->generarTablaPosiciones($idCampeonato),
    		);
    }

    /**
     * Muestra el campeonato en el front!
     * @Route("/campeonatos/mostrar", name="campeonato_mostrar")
     * @Template()
     * @return twig
     * @author ezekiel
     **/
    public function showCampeonatoFrontAction()
    {
        $request = $this->getRequest();
        $idCampeonato = $request->query->get('campeonato');
        return array('campeonato'=>$idCampeonato);
    }

}
 