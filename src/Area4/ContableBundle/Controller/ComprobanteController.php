<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComprobanteController
 *
 * @author jme
 * 
 */

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Form\Items2Type;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Area4\ContableBundle\Form\DocumentoType as Form;
use Area4\ContableBundle\Form\ArticuloType;

/**
 * ComprobanteController
 */
class ComprobanteController extends Controller {

    /**
     * @route("/DocNuevo/{id}", name="DocNuevo")
     * @Template()
     */
    public function nuevoAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        /* @var $DR \Area4\ContableBundle\Entity\DocumentoRepository */
        $DR = $em->getRepository('Area4ContableBundle:Documento');
        /* @var $sf2user Usuario */
//        $sf2user = $this->get('security.context')->getToken()->getUser();
        /* @var $tipo \Area4\ContableBundle\Entity\Tipo */
        $tipo = $em->getReference('Area4ContableBundle:Tipo', $id);
        $entity = $DR->crearDocumento($tipo, null);
        $cf = $em->getReference('Area4UsuarioBundle:Usuario', 0);
        if (\is_object($cf)) {
//            $entity->setResponsable($cf);
            $em->persist($entity);
            $em->flush();
        }
        if ($id == 4)
            return $this->redirect($this->generateUrl('cobrar_cuota',
                            array(
                                'id' => $entity->getId()
                    )));
    }

    /**
     * @route("/editar/{id}", name="editar")
     * @Template("")
     */
    public function editarAction($id) {
        /* @var $em \Doctrine\ORM\EntityManager  */
        $em = $this->getDoctrine()->getEntityManager();
        if ($id > 0) {
            $entity = $em->getRepository('Area4ContableBundle:Documento')->find($id);
            /* @var $entity \Area4\ContableBundle\Entity\Documento */
            if (!$entity)
                throw $this->createNotFoundException('No existe el Comprobante.' . $id);
        } else {
            /* @var $tipo \Area4\ContableBundle\Entity\Tipo */
            $tipo = $em->getReference('Area4ContableBundle:Tipo', -$id);
            /* @var $DR \Area4\ContableBundle\Entity\DocumentoRepository */
            $DR = $em->getRepository('Area4ContableBundle:Documento');
            /* @var $sf2user Usuario */
            $sf2user = $this->get('security.context')->getToken()->getUser();
            /* @var $entity \Area4\ContableBundle\Entity\Documento */
            $entity = $DR->crearDocumento($tipo, $sf2user);
            $cf = $em->getReference('Area4UsuarioBundle:Usuario', 0);
            if (\is_object($cf)) {
                $entity->setJugador($cf);
            } else {
                $entity->setJugador(null);
            }
            $em->persist($entity);
            $em->flush();
        }
        $session = $this->get("session");
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $session->set('comprobante_id', $entity->getId());
        $form = $this->createForm(new \Area4\ContableBundle\Form\ComprobanteType(),
                        $entity);
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Genera la parte del comprobante donde se ve la factua
     * @route("/verCliente/{id}", name="verCliente", defaults={"id" =0})
     * @Template()
     */
    public function verClienteAction($id=null) {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();
        $cliente = $em->getRepository('Area4ContableBundle:Cliente')->find($id);
        if (!$cliente && $id != null)
            throw $this->createNotFoundException('No existe ese Cliente.');
        return array(
            'cliente' => $cliente,
        );
    }

    /**
     * Genera el cuadro dialog de la busqueda en el dialog
     * @route("/buscarJugador/{texto}", name="BuscarJugador", defaults={"texto" = ""})
     * @Template()
     * @param pagina la cualrenderizar si es correcto
     */
    public function BuscarJugadorAction($texto) {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();
        $UR = $em->getRepository('Area4CampeonatoBundle:Jugador');
        /* @var $UR \Area4\ContableBundle\Entity\ClienteRepository */
        $lista = $UR->findAll();
        return array(
            'lista' => $lista,
        );
    }

    /**
     * Genera el cuadro dialog de la busqueda en el dialog
     * @route("/buscarJugador2/{texto}", name="BuscarJugador2")
     * @Template()
     * @param pagina la cualrenderizar si es correcto
     */
    public function BuscarJugador2Action($texto) {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();
        $UR = $em->getRepository('Area4CampeonatoBundle:Jugador');
        /* @var $UR \Area4\ContableBundle\Entity\ClienteRepository */
        $lista = $UR->createQueryBuilder('j')
                ->where('j.apellido like \'%'.$texto.'%\'')
                ->orWhere('j.nombre like \'%'.$texto.'%\'')
                ->orWhere('j.dni like \'%'.$texto.'%\'')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        $session = $this->get("session");
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $item_id = $session->get('modItem_id');
        return array(
            'lista' => $lista,
            'item_id' => $item_id,
        );
    }

    /**
     * Genera el cuadro dialog de la busqueda en el dialog
     * @route("/cambiarJugador", name="cambiarJugador")
     * @Template("Area4ContableBundle:Comprobante:verJugador.html.twig")
     * @param pagina la cualrenderizar si es correcto
     */
    public function cambiarJugadorAction() {
        $request = $this->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $jugador = $request->get('jugador');

        $em = $this->getDoctrine()->getEntityManager();
        $jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($jugador);

        if (!$jug) throw $this->createNotFoundException('No existe ese Cliente.');

        $item = new \Area4\ContableBundle\Entity\Items();
        $item->setJugador($jug);
        $form = $this->createForm(new ArticuloType(),$item );


        return array(
            'jug' => $jug,
            'form' => $form->createView(),
        );
    }

    /**
     * Genera la Lista de Items
     * @route("/listaItems/{id}", name="listaItems",defaults={"id"= null})
     * @template()
     * @return type
     */
    function listaItemsAction($id) {
        if (\is_numeric($id)) {
            $comp_id = $id;
        } else {
            $session = $this->get("session");
            /* @var $session \Symfony\Component\HttpFoundation\Session */
            $comp_id = $session->get('comprobante_id');
        }
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        $doc = $em->getReference('Area4ContableBundle:Documento', $comp_id);
        /* @var $doc \Area4\ContableBundle\Entity\Documento */
        $items = $doc->getItems();
        /* @var $items \Area4\ContableBundle\Entity\Items */
        $doc->calcularTotal();
        //$em->persist($doc);

        return array(
            'documento' => $doc,
            'items' => $items,
        );
    }

    /**
     * Controller para modificar un item
     * @route("/modItem", name="modItem")
     * @template()
     */
    public function modItemAction() {
        $request = $this->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        $item_id = $request->get('id');
        $session = $this->get("session");
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        if (!\is_numeric($item_id)) {
            $doc_id = $session->get('comprobante_id');
            $item = new \Area4\ContableBundle\Entity\Items();
            $doc = $em->getReference('Area4ContableBundle:Documento', $doc_id);
            $item->setDocumento($doc);
        } else
            $item = $em->getReference('Area4ContableBundle:Items', $item_id);
        if (!$item) throw $this->createNotFoundException('No existe item con ID ' . $item_id);
        //echo '<script type="text/javascript">console.log("'.$doc_id.'");</script>';
        $form = $this->createForm(new ArticuloType(),$item);
        /**
         * La creo para pasar el nombre del producto inicial o en blanco
         */
        $nombrePro = (\is_object($item->getProducto())) ? $item->getProducto()->getNombre() : '';
        $session->set('modItem_id', $item->getId());
        return array(
            'entity' => $item,
            'form' => $form->createView(),
            'nombrePro' => $nombrePro,
        );
    }

    /**
     * Genera el cuadro de productos, deacuerdo al texto
     * @route("/cuadroPro/{cant}/{texto}", name="cuadroPro",  defaults={"texto" = "", "cant"=10})
     * @template()
     */
    public function cuadroProAction($texto, $cant) {
        $em = $this->getDoctrine()->getEntityManager();
        $fecha = new \DateTime('now');
        $lista = $em->getRepository('Area4ContableBundle:Producto')->buscarVigentes($fecha->format('Y-m-d'));
        return array(
            'lista' => $lista,
        );
    }

    /**
     * @route("/BuscarPrecioProducto/{prod}/{cant}", name="BuscarPrecioProducto", defaults={"prod"=null,"cant"=1})
     * @template("Area4ContableBundle:Comprobante:BuscarPrecioProducto.txt.twig")
     */
    public function BuscarPrecioProductoAction($prod, $cant) {
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        if (!\is_numeric($prod)) {
            throw $this->createNotFoundException('no es numero ' . $prod);
        }
        $pro = $em->getReference('Area4ContableBundle:Producto', $prod);
        /* @var $pro \Area4\CatalogoBundle\Entity\Producto */
        $precio = $pro->precioXCant($cant);
        if (!\is_numeric($precio)) {
            throw $this->createNotFoundException('no es precio ' . $precio);
        }
        return array(
            'precio' => $precio,
        );
    }

    /**
     * @route("/BuscarNombreProducto/{prod}", name="BuscarNombreProducto", defaults={"prod"=null})
     * @template("Area4ContableBundle:Comprobante:BuscarPrecioProducto.txt.twig")
     */
    public function BuscarNombreProductoAction($prod) {
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        if (!\is_numeric($prod)) {
            throw $this->createNotFoundException('no es numero ' . $prod);
        }
        $pro = $em->getReference('Area4ContableBundle:Producto', $prod);
        /* @var $pro \Area4\CatalogoBundle\Entity\Producto */
        return array(
            'precio' => $pro->getNombre(),
        );
    }

    /**
     * @route("/updateProducto/{id}", name="updateProducto", defaults={"id"=null})
     * @template()
     * @param id id del item a modificar
     */
    public function updateProductoAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        if (\is_numeric($id) and $id > 0) {
            $item = $em->getReference('Area4ContableBundle:Items', $id);
            /* @var $item \Area4\ContableBundle\Entity\Items */
        } else {
            $item = new \Area4\ContableBundle\Entity\Items();
        }

        if (!\is_object($item)) throw $this->createNotFoundException('Unable to find Items entity.');
        /* @var $item \Area4\ContableBundle\Entity\Items */
        $form = $this->createForm(new ArticuloType(), $item);

        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            /*$documento = new Documento();
            $documento->setId($item->getDocumento());
            $documento->setTotal();*/
            $item->calcularTotal();
            //		$item->getDocumento()->addItems($item);
            $item->getDocumento()->calcularTotal();
            $item->setUpdatedAt(new \DateTime('now'));
            $item->setDetalle($item->getProducto()->getNombre());
            //		$em->persist($item->getDocumento());
            $em->persist($item);
            $em->persist($item->getDocumento());
            $em->flush();

            return $this->forward('Area4ContableBundle:Comprobante:listaItems',
                    array('id' => $item->getDocumento()->getId()));
        }

        return array(
            'edit_form' => $form->createView(),
            'entity' => $item,
        );
    }

    /**
     * @route("/updateProdFamiliar/{id}", name="updateFamiliar", defaults={"id"=null})
     * @template()
     * @param id id del item a modificar
     */
    public function updateProductoFamiliarAction($id) {
        echo '<script>console.log("updateProductoFamiliarAction :D")</script>';
        $em = $this->getDoctrine()->getEntityManager();
        if (\is_numeric($id) and $id > 0) {
            $item = $em->getReference('Area4ContableBundle:Items', $id);
            /* @var $item \Area4\ContableBundle\Entity\Items */
        } else {
            $item = new \Area4\ContableBundle\Entity\Items();
        }

        if (!\is_object($item)) throw $this->createNotFoundException('No se encontro el Item buscado.');
        /* @var $item \Area4\ContableBundle\Entity\Items */

        $form = $this->createForm(new ArticuloType(), $item);
        $request = $this->getRequest();
        $form->bindRequest($request);

        $session = $this->get("session");
        $dni = $request->get('dniGrupoFamiliar');
        $GrupoFamiliar = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->findOneByDni($dni);

        if ($form->isValid()) {
            $jugadores = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByGrupoFamiliar($GrupoFamiliar->getId());
            if(!$jugadores) throw $this->createNotFoundException('No se encontraron los Jugadores asociados al grupo familiar '.$GrupoFamiliar);
            foreach ($jugadores as $jug) {
                $it = new \Area4\ContableBundle\Entity\Items();
                $it->setJugador($jug);
                $it->setCantidad($item->getCantidad());
                $it->setProducto($item->getProducto());
                $it->setDocumento($item->getDocumento());
                $it->calcularTotal();
                $it->getDocumento()->calcularTotal();
                $it->setUpdatedAt(new \DateTime('now'));
                $it->setDetalle($item->getProducto()->getNombre());
                $em->persist($it);
            }
                $em->flush();

            return $this->forward('Area4ContableBundle:Comprobante:listaItems',
                    array('id' => $item->getDocumento()->getId()));
        }

        return array(
            'edit_form' => $form->createView(),
            'entity' => $item,
        );
    }


    /**
     * Pantalla generadora de nuevos Items
     * @param $id integer ID del documento a agregar
     * @route("/nuevoItem/{id}", name="nuevoItem")
     * @template()
     */
    public function nuevoItem($id) {
        $em = $this->getDoctrine()->getEntityManager();
        /* @var $em \Doctrine\ORM\EntityManager */
        $doc = $em->getReference('Area4ContableBundle:Documento', $id);
        if (!$doc) {
            throw $this->createNotFoundException('No existe Documento con ID ' . $id);
        }
        $item = new \Area4\ContableBundle\Entity\Items();
        $item->setDocumento($doc);
        $form = $this->createForm(new \Area4\ContableBundle\Form\ArticuloType(), $item);

        return array(
            'entity' => $item,
            'form' => $form->createView(),
        );
    }

    /**
     * @route("/cobrarCuota/{id}", name="cobrar_cuota")
     * @Template("Area4ContableBundle:Comprobante:cobrarCuota.html.twig")
     * @param integer $id
     */
    public function cobrarCuotaAction($id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        if (is_numeric($id) and $id > 0) {
            $entity = $em->getRepository('Area4ContableBundle:Documento')->find($id);
            if (!$entity)
                throw $this->createNotFoundException('No existe el Comprobante.' . $id);
        }
        else {
            $tipo = $em->getReference('Area4ContableBundle:Tipo', -$id);
            $DR = $em->getRepository('Area4ContableBundle:Documento');
            $sf2user = $this->get('security.context')->getToken()->getUser();
            $entity = $DR->crearDocumento($tipo, $sf2user);
            $em->persist($entity);
            $em->flush();
        }
        $session = $this->get("session");
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $session->set('comprobante_id', $entity->getId());
        $form = $this->createForm(new \Area4\ContableBundle\Form\ComprobanteType(), $entity);
        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }



    /**
     * Cancela un documento
     * @route("/cancelarOperacion/{idDocumento}", name="cancelar_operacion")
     * @author ezekiel
     **/
    public function cancelarOperacionAction($idDocumento)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $documento = $em->getRepository('Area4ContableBundle:Documento')->find($idDocumento);
        if (!$documento)
                throw $this->createNotFoundException('No existe el documento.' . $idDocumento);
        $documento->setEstado(-1);
        $em->persist($documento);
        $em->flush();
        echo "<script>alert('Documento cancelado')</script>";
        return $this->redirect($this->generateUrl('documento'));
    }

}
?>