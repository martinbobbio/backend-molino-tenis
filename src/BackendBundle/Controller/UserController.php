<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Notice;

class UserController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(){
        
        $con = $this->getDoctrine()->getManager();
        $user = $con->getRepository('BackendBundle:User')->findAll();

        return $this->render('user/index.html.twig', array('user' => $user));

    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BackendBundle:User')->find($id);

        $form = $this->createCustomForm($user->getId(),'DELETE', 'user_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->remove($user) ;
            $em->flush();

            return $this->redirectToRoute('user_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }
}