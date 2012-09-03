<?php
namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\Documento;
use Area4\ContableBundle\Entity\LineadeDocumento;
use Area4\ContableBundle\Entity\Producto;
use Symfony\Component\HttpFoundation\Response;
/**
 * EspecificaciondeProducto controller.
 *
 * @Route("/lineadedocumento")
 */
class LineadeDocumentoController extends Controller
{
    /**
     * Displays a form to create a new EspecificaciondeProducto entity.
     *
     * @Route("/new/{idDocumento}", name="lineadedocumento_new")
     * @Template()
     * @param idProducto: id del producto
     * @param idDocumento: id del Documento
     */
    public function newAction($idDocumento)
    {

        $lineadedocumento = new LineadeDocumento();
        
        $em = $this->getDoctrine()->getEntityManager();
        $request = $request = $this->get('request');
        $idProducto = $request->request->get('idProducto');

        $documento = $em->getRepository('Area4ContableBundle:Documento')->find($idDocumento);
        $producto = $em->getRepository('Area4ContableBundle:Producto')->find($idProducto);

        if(!$documento) throw $this->createNotFoundException('No se encontro el documento.');
        if(!$producto) $this->createNotFoundException('No se encontro el producto.');

        $lineadedocumento->setProducto($producto);
        $lineadedocumento->setDocumento($documento);
        $em->persist($lineadedocumento);
        $em->flush();

        return new Response($lineadedocumento->getId(),200);
    }

    /**
     * Elimina una linea de documento del documento
     *
     * @Route("/remove/{idDocumento}", name="lineadedocumento_remove")
     * @Template()
     * @return Response
     * @author ezekiel
     **/
    public function removeAction($idDocumento)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $request = $this->get('request');
        $idLineadeDocumento = $request->request->get('idLineadeDocumento');
        $lineadedocumento = $em->getRepository('Area4ContableBundle:LineadeDocumento')->find($idLineadeDocumento);

        if(!$lineadedocumento) $this->createNotFoundException('No se encontro la linea de documento.');

        $em->remove($lineadedocumento);
		$em->flush();

        return new Response();	
    }

    /**
     * Lista las lineas de documento de un documento determinado
     *
     * @Route("/list/{idDocumento}", name="lineadedocumento_list")
     * @Template()
     * @return array
     * @author ezekiel
     **/
    public function listAction($idDocumento)
    {
        $em = $this->getDoctrine()->getEntityManager();
		$lineadedocumento = $em->getRepository('Area4ContableBundle:LineadeDocumento')->findByDocumento($idDocumento);

        if(!$lineadedocumento) $this->createNotFoundException('No se encontraron las lineas de documento.');

        return array('lineasdeDocumento' => $lineadedocumento);
    }
}