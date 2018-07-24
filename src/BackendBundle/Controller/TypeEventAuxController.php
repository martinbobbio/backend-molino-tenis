<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\TypeEvent;
use BackendBundle\Entity\Log;

class TypeEventAuxController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(){
        
        $con = $this->getDoctrine()->getManager();
        $type_event = $con->getRepository('BackendBundle:TypeEvent')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','type_event_delete');

        return $this->render('typeevent/index.html.twig', array('type_event' => $type_event,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, TypeEvent $type_event){
        
        $editForm = $this->createForm('BackendBundle\Form\TypeEventType', $type_event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->createLog("edit");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_event_index', array('id' => $type_event->getId()));
        }

        return $this->render('typeevent/edit.html.twig', array(
            'type_event' => $type_event,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $type_event = new TypeEvent();
        $form = $this->createForm('BackendBundle\Form\TypeEventType', $type_event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->createLog("new");
            $em = $this->getDoctrine()->getManager();
            $em->persist($type_event);
            $em->flush();

            return $this->redirectToRoute('type_event_index');
        }

        return $this->render('typeevent/new.html.twig', array(
            'type_event' => $type_event,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $type_event = $em->getRepository('BackendBundle:TypeEvent')->find($id);

        $form = $this->createCustomForm($type_event->getId(),'DELETE', 'type_event_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $this->createLog("delete");
                $em->remove($type_event) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($type_event) ;
            $em->flush();

            return $this->redirectToRoute('type_event_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

    //--------------------LOG-----------------------------------
    private function createLog($type){
       $log = new Log();
       $log = $log->createLog($type,"tipo de evento",$this->container->get('security.context')->getToken()->getUser());
       $this->getDoctrine()->getManager()->persist($log);
   }
}