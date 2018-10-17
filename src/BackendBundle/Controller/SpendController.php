<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Spend;
use BackendBundle\Entity\Log;

class SpendController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(Request $request){
        
        $con = $this->getDoctrine()->getManager();
        $spendQuery = $con->getRepository('BackendBundle:Spend')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','spend_delete');

        $paginator  = $this->get('knp_paginator');
        $spend = $paginator->paginate(
          $spendQuery,
          $request->query->getInt('page', 1),
          20);

        return $this->render('spend/index.html.twig', array('spend' => $spend,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Spend $spend){
        
        $editForm = $this->createForm('BackendBundle\Form\SpendType', $spend);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $spend->setType($spend->getType()->getTitle());
            $spend->generateTotal();
            $this->createLog("edit");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spend_index', array('id' => $spend->getId()));
        }

        return $this->render('spend/edit.html.twig', array(
            'spend' => $spend,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $spend = new Spend();
        $form = $this->createForm('BackendBundle\Form\SpendType', $spend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $spend->setType($spend->getType()->getTitle());
            $spend->generateTotal();
            $this->createLog("new");
            $em = $this->getDoctrine()->getManager();
            $em->persist($spend);
            $em->flush();

            return $this->redirectToRoute('spend_index');
        }

        return $this->render('spend/new.html.twig', array(
            'spend' => $spend,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $spend = $em->getRepository('BackendBundle:Spend')->find($id);

        $form = $this->createCustomForm($spend->getId(),'DELETE', 'spend_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $this->createLog("delete");
                $em->remove($spend) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($spend) ;
            $em->flush();

            return $this->redirectToRoute('spend_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

    //--------------------LOG-----------------------------------
    private function createLog($type){
       $log = new Log();
       $log = $log->createLog($type,"recaudacion",$this->container->get('security.context')->getToken()->getUser());
       $this->getDoctrine()->getManager()->persist($log);
   }
}