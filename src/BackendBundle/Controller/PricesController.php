<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Prices;
use BackendBundle\Entity\Log;

class PricesController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(){
        
        $con = $this->getDoctrine()->getManager();
        $prices = $con->getRepository('BackendBundle:Prices')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','prices_delete');

        return $this->render('prices/index.html.twig', array('prices' => $prices,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Prices $prices){
        
        $editForm = $this->createForm('BackendBundle\Form\PricesType', $prices);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->createLog("edit");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prices_index', array('id' => $prices->getId()));
        }

        return $this->render('prices/edit.html.twig', array(
            'prices' => $prices,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $prices = new Prices();
        $form = $this->createForm('BackendBundle\Form\PricesType', $prices);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->createLog("new");
            $em = $this->getDoctrine()->getManager();
            $em->persist($prices);
            $em->flush();

            return $this->redirectToRoute('prices_index');
        }

        return $this->render('prices/new.html.twig', array(
            'prices' => $prices,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $prices = $em->getRepository('BackendBundle:Prices')->find($id);

        $form = $this->createCustomForm($prices->getId(),'DELETE', 'prices_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $this->createLog("delete");
                $em->remove($prices) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($prices) ;
            $em->flush();

            return $this->redirectToRoute('prices_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

    //--------------------LOG-----------------------------------
    private function createLog($type){
       $log = new Log();
       $log = $log->createLog($type,"precio",$this->container->get('security.context')->getToken()->getUser());
       $this->getDoctrine()->getManager()->persist($log);
   }
}