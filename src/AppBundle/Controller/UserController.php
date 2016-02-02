<?php
/**
 * Created by PhpStorm.
 * User: edgar
 * Date: 10/11/15
 * Time: 17:33
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{

    /**
     *
     * @Route(
     *          path="/user",
     *          name="app_user_index"
     * )
     *
     * @return mixed
     */
    public function indexAction()
    {

        //crear usuario

        $m =  $this->getDoctrine()->getManager();

        /*

        $user1 = new User();

        $user1->setEmail('user1@email.com');
        $user1->setPassword('1234');

        $m->persist($user1);// persist esto va a ir a la base de datos

        $m->flush();


        $user2 = new User();
        $user2->setEmail('user2@email.com');
        $user2->setPassword('1234');

        $m->persist($user2);// persist esto va a ir a la base de datos

        $m->flush();

        */

        //recuperar usuario de la base de datos

        $repository = $m->getRepository('AppBundle:User');

        /**
         * @var User $user
         */

        // $user = $repository->findOneByUsername('user2');


        //modificar usuario

        //  $user->setEmail('nuevo@email.com'); // persist no hace falta porque ya viene de la base de datos


        //borrar usuario

        //$m->remove($user1);


        // $m->flush();


        // recuperar varios usuarios

        $users = $repository->findAll();

        //$m->flush();


        return $this->render(':user:index.html.twig', ['users' => $users]);

        //return $this->render('');
    }

    /**
     * @Route(
     *      path="/insert",
     *      name="app_user_insert"
     * )
     */
    public function insertAction()
    {
        $user = new User(); //se va a iniciar con el usuario que acabamos de crear      //mostrar, recoger datos, validar
        $form = $this->createForm(new UserType(), $user); //crear el formulario

        return $this->render(':user:form.html.twig',
            [
                'form' => $form->createView(),      //nos crea la vista de este formulario
                'action' => $this->generateUrl('app_user_doInsert'),
            ]
        );
    }

    /**
     * @Route(
     *         path="/do-insert",
     *         name="app_user_doInsert"
     * )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doInsertAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);  //rellena el usuario que acabamos de crear

        if ($form->isValid()){                  //validar
            $m = $this->getDoctrine()->getManager();
            $m->persist($user);
            $m->flush();

            $this->addFlash('messages', 'User added');

            return $this->redirectToRoute('app_user_index');
        }

        //si no es valido se muestran los errores
        $this->addFlash('messages', 'Review your form data');

        return $this->render(':user:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_user_doInsert')
            ]
        );
    }




    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *          path="/update/{id}",
     *          name="app_user_update")
     *
     */

    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');

        $user = $repository->find($id);

        $form = $this->createForm(new UserType(), $user);

        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doUpdate', ['id' => $id])
            ]
        );
    }

    /**
     * @Route(
     *      path="/do-update/{id}",
     *      name="app_user_doUpdate"
     * )
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function doUpdateAction($id, Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');
        $user       = $repository->find($id);
        $form       = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'User updated');

            return $this->redirectToRoute('app_user_index');
        }


        $this->addFlash('messages', 'Review your form');

        return $this->render(':user:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_user_doUpdate', ['id' => $id]),
            ]
        );
    }



    /**
     * @Route(
     *      path="/remove/{id}",
     *      name="app_user_remove"
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:User');

        $user = $repository->find($id);


        $m->remove($user);
        $m->flush();

        $this->addFlash('messages', 'User has been removed');

        return $this->redirectToRoute('app_user_index');

    }
}
//producto entidad

//id nombre descripcion precio si esta disponible o no fechac reacion fecha modificacion