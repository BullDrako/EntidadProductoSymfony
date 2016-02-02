<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 12/11/15
 * Time: 20:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Producto;
use AppBundle\Form\ProductoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    /**
     * @Route(
     *          path="/producto",
     *          name="app_producto_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();

       /* $producto1 = new Producto();
        $producto1->setNombre('aceite');
        $producto1->setDescripcion('aceite de oliva');
        $producto1->setPrecio('2');
        $producto1->setDisponible('SI');


        $m->persist($producto1);

        $m->flush();


        $producto2 = new Producto();
        $producto2->setNombre('vinagre');
        $producto2->setDescripcion('vinagre de modena');
        $producto2->setPrecio('3');
        $producto2->setDisponible('SI');

        $m->persist($producto2);

        $m->flush();
*/

        $repository = $m->getRepository('AppBundle:Producto');

        $productos = $repository->findAll();

       return $this->render(':producto:index.html.twig', ['productos' => $productos]);


    }

    /**
     * @Route(
     *          path="/insertar",
     *         name="app_producto_insertar"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function insertarAction()
    {
        $producto = new Producto();
        $form = $this->createForm(new ProductoType(), $producto); //crear el formulario

        return $this->render(':producto:formulario.html.twig',
            [
                'form' => $form->createView(),      //nos crea la vista de este formulario
                'action' => $this->generateUrl('app_producto_doInsertar'),
            ]
        );
    }

    /**
     * @Route(
     *         path="/do-insertar",
     *         name="app_producto_doInsertar"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doInsertarAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm(new ProductoType(), $producto);

        $form->handleRequest($request);  //rellena el usuario que acabamos de crear

        if ($form->isValid()){                  //validar
            $m = $this->getDoctrine()->getManager();
            $m->persist($producto);
            $m->flush();

            $this->addFlash('messages', 'Producto añadido');

            return $this->redirectToRoute('app_producto_index');
        }

        //si no es valido se muestran los errores
        $this->addFlash('messages', 'Revisa los datos del formulario');

        return $this->render(':producto:formulario.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_producto_doInsertar')
            ]
        );
    }

    /**
     *
     * @Route(
     *          path="/actualizar/{id}",
     *          name="app_producto_actualizar")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function actualizarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $producto = $repository->find($id);

        $form = $this->createForm(new ProductoType(), $producto);


        return $this->render(':producto:formulario.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_producto_doActualizar', ['id' => $id])
            ]
        );
    }

    /**
     * @Route(
     *          path="/do-actualizar/{id}",
     *          name="app_producto_doActualizar")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function doActualizarAction($id, Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $producto   = $repository->find($id);
        $form       = $this->createForm(new ProductoType(), $producto);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'Producto actualizado');

            return $this->redirectToRoute('app_producto_index');
        }


        $this->addFlash('messages', 'Revisa tu formulario');

        return $this->render(':producto:formulario.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_producto_doActualizar', ['id' => $id]),
            ]
        );
    }

    /**
     * * @Route(
     *          path="/eliminar/{id}",
     *          name="app_producto_eliminar"
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $producto = $repository->find($id);


        $m->remove($producto);
        $m->flush();

        $this->addFlash('messages', 'Producto ha sido eliminado');

        return $this->redirectToRoute('app_producto_index');

    }


}

