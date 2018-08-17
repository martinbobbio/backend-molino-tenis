<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Entity\Finance;
use BackendBundle\Entity\Log;

class FinanceController extends Controller
{

    //---------------------INDEX------------------------------

    public function indexAction(){
        
        $con = $this->getDoctrine()->getManager();
        $finance = $con->getRepository('BackendBundle:Finance')->findAll();

        $delete_form = $this->createCustomForm(':ID','DELETE','finance_delete');

        return $this->render('finance/index.html.twig', array('finance' => $finance,'delete_form' => $delete_form->createView() ));

    }

    //---------------------EDIT------------------------------

    public function editAction(Request $request, Finance $finance){
        
        $editForm = $this->createForm('BackendBundle\Form\FinanceType', $finance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->createLog("edit");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('finance_index', array('id' => $finance->getId()));
        }

        return $this->render('finance/edit.html.twig', array(
            'finance' => $finance,
            'edit_form' => $editForm->createView(),
        ));

    }

    //---------------------NEW------------------------------

    public function newAction(Request $request)
    {
        $finance = new Finance();
        $form = $this->createForm('BackendBundle\Form\FinanceType', $finance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->createLog("new");
            $em = $this->getDoctrine()->getManager();
            $em->persist($finance);
            $em->flush();

            return $this->redirectToRoute('finance_index');
        }

        return $this->render('finance/new.html.twig', array(
            'finance' => $finance,
            'form' => $form->createView(),
        ));
    }

    //---------------------DELETE------------------------------

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $finance = $em->getRepository('BackendBundle:Finance')->find($id);

        $form = $this->createCustomForm($finance->getId(),'DELETE', 'finance_delete');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($request->isXMLHttpRequest()){
                
                $this->createLog("delete");
                $em->remove($finance) ;
                $em->flush();   
                return new Response(json_encode(array('removed' => 1)),200, array('Content-Type' => 'application/json'));
            }

            $em->remove($finance) ;
            $em->flush();

            return $this->redirectToRoute('finance_index');
        }
    }

    //---------------------FORMS------------------------------

    private function createCustomForm($id,$method,$route){
        return $this->createFormBuilder()->setAction($this->generateUrl($route, array ('id' => $id)))->setMethod($method)->getForm();
    }

    //--------------------LOG-----------------------------------
    private function createLog($type){
       $log = new Log();
       $log = $log->createLog($type,"abono",$this->container->get('security.context')->getToken()->getUser());
       $this->getDoctrine()->getManager()->persist($log);
   }
}