<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Event;
use BackendBundle\Entity\Log;

class EventController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(){
        
        $con = $this->getDoctrine()->getManager();
        $event = $con->getRepository('BackendBundle:Event')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','event_delete');

        return $this->render('event/index.html.twig', array('event' => $event,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Event $event){
        
        $editForm = $this->createForm('BackendBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $event->setType($event->getType()->getTitle());

            $this->createLog("edit");

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index', array('id' => $event->getId()));
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('BackendBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->createLog("new");
            $event->setType($event->getType()->getTitle());
            $event->setIsSuspended(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('BackendBundle:Event')->find($id);

        $form = $this->createCustomForm($event->getId(),'DELETE', 'event_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $this->createLog("delete");
                $em->remove($event) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($event) ;
            $em->flush();

            return $this->redirectToRoute('event_index');
        }
    }

    //---------------------SUSPENDED------------------------------

    public function suspendedAction(Request $request, Event $event){
        
        if($event->getIsSuspended() == 1)
            $event->setIsSuspended(0);
        else
            $event->setIsSuspended(1);

        $this->createLog("edit");

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('event_index');

    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

     //---------------------LOGS------------------------------

     private function createLog($type){
        $log = new Log();
        $log = $log->createLog($type,"partido",$this->container->get('security.context')->getToken()->getUser());
        $this->getDoctrine()->getManager()->persist($log);
    }
}